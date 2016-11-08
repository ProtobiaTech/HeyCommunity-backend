<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Thumbnail;
use Auth;
use App\Timeline;
use App\TimelineLike;
use App\TimelineImg;
use App\TimelineVideo;
use App\TimelineComment;
use App\Notice;
use App\Events\TriggerNoticeEvent;

class TimelineController extends Controller
{
    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['postStore',  'postStoreImg', 'postSetLike', 'postDestroy']]);
    }

    /**
     * Get all of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return object The all timelines
     */
    public function getIndex(Request $request)
    {
        $query = Timeline::with(['author', 'author_like', 'comments'])
            ->orderBy('id', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10);

        if ($request->type === 'refresh') {
            $query->where('id', '>', $request->id);
        } else if ($request->type === 'infinite') {
            $query->where('id', '<', $request->id);
        }

        $timelines = $query->get()->each(function($item, $key) {
            if (Auth::guest()) {
                $item->is_like = false;
            } else {
                $item->is_like = TimelineLike::where(['timeline_id' => $item->id, 'user_id' => Auth::user()->id])->count() ? true : false;
            }
            if ($item->imgs) {
                $item->imgs = TimelineImg::getImgs($item->imgs);
            }
        })->toArray();

        return $timelines;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object The new timeline
     */
    public function postStore(Request $request)
    {
        $this->validate($request, [
            'content'       =>      'required_without:video|required_without:imgs',
            'imgs'          =>      'required_without:video|required_without:content',
            'video'         =>      'required_without:imgs|required_without:content',
        ]);

        $Timeline = new Timeline;

        // have content
        if ($request->content) {
            $Timeline->content  =   $request->content;
        }

        // have imgs
        if ($request->imgs) {
            $Timeline->imgs     =   $request->imgs;
        }

        // have video
        if ($request->video) {
            $TimelineVideo = TimelineVideo::findOrFail($request->video);
            $Timeline->video    =   $TimelineVideo->uri;
            $Timeline->poster   =   $TimelineVideo->poster;
        }

        $Timeline->user_id      =   Auth::user()->id;

        if ($Timeline->save()) {
            if (isset($TimelineVideo)) {
                $TimelineVideo->timeline_id = $Timeline->id;
                $TimelineVideo->save();
            }

            if ($Timeline->imgs) {
                $imgs = json_decode($Timeline->imgs);
                TimelineImg::whereIn('id', $imgs)->update(['timeline_id' => $Timeline->id]);
            }
        }

        return Timeline::with(['author', 'comments', 'author_like'])->findOrFail($Timeline->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return object The specified timeline
     */
    public function getShow($id)
    {
        return Timeline::with(['author', 'comments', 'author_like'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @todo
     */
    public function postUpdate(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string The results
     */
    public function postDestroy(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $Timeline = Timeline::findOrFail($request->id);

        if ($Timeline->user_id === Auth::user()->id) {
            return $Timeline->delete() ? ['success'] : response('fail', 500);
        } elseif (Auth::user()->id === Auth::user()->id) {
            return $Timeline->delete() ? ['success'] : response('fail', 500);
        }

        return abort(403, 'Insufficient permissions');
    }

    /**
     * Set timeline is like
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object The timeline
     */
    public function postSetLike(Request $request)
    {
        $this->validate($request, [
            'id'        =>      'required',
        ]);

        $TimelineLike = TimelineLike::where(['timeline_id' => $request->id, 'user_id' => Auth::user()->id])->first();
        $Timeline = Timeline::findOrFail($request->id);

        if ($TimelineLike) {
            $TimelineLike->delete();
            $Timeline->decrement('like_num');
        } else {
            $TimelineLike = new TimelineLike;
            $TimelineLike->user_id      =       Auth::user()->id;
            $TimelineLike->timeline_id  =       $request->id;
            $TimelineLike->save();
            $Timeline->increment('like_num');

            if ($Timeline->user_id !== Auth::user()->id) {
                event(new TriggerNoticeEvent($TimelineLike, $Timeline, 'timeline_like'));
            }
        }

        $Timeline = $Timeline->with(['author', 'author_like', 'comments'])->findOrFail($request->id);
        $Timeline->is_like = TimelineLike::where(['timeline_id' => $Timeline->id, 'user_id' => Auth::user()->id])->count() ? true : false;
        if ($Timeline->imgs) {
            $Timeline->imgs = TimelineImg::getImgs($Timeline->imgs);
        }
        return $Timeline;
    }

    /**
     * Store comment for timeline
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object The timeline
     */
    public function postStoreComment(Request $request)
    {
        $this->validate($request, [
            'timeline_id'           =>      'required',
            'timeline_comment_id'   =>      '',
            'content'               =>      'required',
        ]);

        $Timeline = Timeline::findOrFail($request->timeline_id);
        $TimelineComment = new TimelineComment;

        if ($request->timeline_comment_id) {
            $TimelineComment->parent_id   =   $request->timeline_comment_id;
        }
        $TimelineComment->timeline_id   =   $request->timeline_id;
        $TimelineComment->user_id       =   Auth::user()->id;
        $TimelineComment->content       =   $request->content;
        $TimelineComment->save();
        $Timeline->increment('comment_num');

        if ($TimelineComment->parent_id > 0) {
            if ($TimelineComment->parent->user_id !== Auth::user()->id) {
                event(new TriggerNoticeEvent($TimelineComment, $TimelineComment->parent, 'timeline_comment_comment'));
            }
        } else {
            if ($Timeline->user_id !== Auth::user()->id) {
                event(new TriggerNoticeEvent($TimelineComment, $Timeline, 'timeline_comment'));
            }
        }

        $Timeline = $Timeline->with(['author', 'author_like', 'comments'])->findOrFail($request->timeline_id);
        $Timeline->is_like = TimelineLike::where(['timeline_id' => $Timeline->id, 'user_id' => Auth::user()->id])->count() ? true : false;
        if ($Timeline->imgs) {
            $Timeline->imgs = TimelineImg::getImgs($Timeline->imgs);
        }
        return $Timeline;
    }

    /**
     *
     */
    public function postStoreImg(Request $request)
    {
        $files = $request->file('uploads');

        $ret = [];
        foreach($files as $k => $file) {
            $uploadPath = '/uploads/timeline/';
            $fileName   = str_random(6) . '_' . $file->getClientOriginalName();
            if ($file->move(public_path() . $uploadPath, $fileName)) {
                $TimelineImg = new TimelineImg();
                $TimelineImg->user_id   =   Auth::user()->id;
                $TimelineImg->uri       =   $uploadPath . $fileName;
                $TimelineImg->save();

                $ret['imgs'][$k]['id']  = $TimelineImg->id;
                $ret['imgs'][$k]['uri'] = $uploadPath . $fileName;
            }
        }

        return $ret;
    }

    /**
     *
     */
    public function postStoreVideo(Request $request)
    {
        $files = $request->file('uploads');
        $file = $files[0];

        $uploadPath = '/uploads/timeline/';
        $fileName   = str_random(6) . '_' . $file->getClientOriginalName();

        if ($file->move(public_path() . $uploadPath, $fileName)) {
            $videoPath = $uploadPath . $fileName;
            $thumbnailImage = $fileName . '.jpg';
            $posterPath = $uploadPath . $thumbnailImage;

            $ffmpeg = \FFMpeg\FFMpeg::create([
                'ffmpeg.binaries'  => env('BIN_FFMPEG', '/usr/bin/ffmpeg'),
                'ffprobe.binaries' => env('BIN_FFPROBE', '/usr/bin/ffprobe'),
            ]);
            $video = $ffmpeg->open(public_path() . $videoPath);
            $video->frame(\FFMpeg\Coordinate\TimeCode::fromSeconds(0))->save(public_path() . $posterPath);

            $TimelineVideo = new TimelineVideo();
            $TimelineVideo->user_id   =   Auth::user()->id;
            $TimelineVideo->uri       =   $videoPath;

            $TimelineVideo->poster    =   $posterPath;
            $TimelineVideo->save();

            return $TimelineVideo;
        }

        return response('upload video failed', 500);
    }
}
