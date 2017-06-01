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
use App\Http\Controllers\Api\Transform\TimelineTransform;

/**
 * @Resource("Timeline", uri="/timelines")
 */
class TimelineController extends BaseController
{

    /**
     * The construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['only'=>[]]);
    }

    /**
     * Show all timelines.
     *
     * Get a JSON representation of all the timelines.
     *
     * @Get("/")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo"}),
     *      @Response(200, body={"data": []}),
     * })
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
        });

        return $this->response
                    ->collection($timelines, new TimelineTransform)
                    ->setStatusCode(200);
    }

    /**
     * Get one of the resource according $id.
     *
     * @Get("/{id}")
     * @Versions({"v1"})
     * @Transaction({
     *      @Response(200, body={"data": {}}),
     *      @Response(404, body={"message":"Not Found","status_code":404})
     * })
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return object The timeline
     */
    public function show(Request $request, $id)
    {
        $timeline = Timeline::where('id', $id)
                    ->first();
        if ($timeline) {
            return $this->response
                        ->item($timeline, new TimelineTransform)
                        ->setStatusCode(200);
        } else {
            return $this->errorNotFound();
        }
    }
}
