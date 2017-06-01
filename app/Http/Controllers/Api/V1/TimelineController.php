<?php

namespace App\Http\Controllers\Api\V1;

use FFMpeg\FFMpeg;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Storage;
use Thumbnail;
use App\Timeline;
use App\TimelineLike;
use App\TimelineImg;
use App\TimelineVideo;
use App\TimelineComment;
use App\Notice;
use App\Events\TriggerNoticeEvent;
use Dingo\Api\Routing\Helpers;

class TimelineController extends Controller
{
    use Helpers;

    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('api.auth', ['only'=>[]]);
    }

    /**
     * Get all of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return object The all timelines
     */
    public function index(Request $request)
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

        $user = $this->auth->user();

        $timelines = $query->get()->each(function($item, $key) use ($user) {
            if (!$user) {
                $item->is_like = false;
            } else {
                $item->is_like = TimelineLike::where([
                                    'timeline_id' => $item->id,
                                    'user_id' => $user->id
                                ])->exists() ? true : false;
            }
            if ($item->imgs) {
                $item->imgs = TimelineImg::getImgs($item->imgs);
            }
        })->toArray();

        return $timelines;
    }

    /**
     * Get one of the resource according $id.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return object The timeline
     */
    public function detail(Request $request, $id)
    {
        $timeline = Timeline::where('id', $id)
                    ->first();
        return $timeline;
    }
}
