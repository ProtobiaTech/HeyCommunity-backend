<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

use App\Timeline;
use App\Topic;
use App\TopicComment;
use App\TimelineImg;
use App\TimelineLike;
use App\TimelineComment;
use App\User;
use App\Notice;
use App\Dataset;


class TrendController extends Controller
{
    /**
     *
     */
    public function getAll(Request $request)
    {
        $datasets[] = new Dataset(trans('dashboard.Timeline'), 'rgba(115,19,12,0.4)');
        $dataSources[] = Timeline::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });

        $datasets[] = new Dataset(trans('dashboard.TimelineLike'), 'rgba(115,19,222,0.4)');
        $dataSources[] = TimelineLike::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });

        $datasets[] = new Dataset(trans('dashboard.TimelineComment'), 'rgba(115,19,92,0.4)');
        $dataSources[] = TimelineComment::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });

        $datasets[] = new Dataset(trans('dashboard.Topic'), 'rgba(48,129,8,0.4)');
        $dataSources[] = Topic::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });

        $datasets[] = new Dataset(trans('dashboard.TopicComment'), 'rgba(48,129,88,0.4)');
        $dataSources[] = TopicComment::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });

        $datasets[] = new Dataset(trans('dashboard.User'), 'rgba(75,99,9,0.4)');
        $dataSources[] = User::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });

        $datasets[] = new Dataset(trans('dashboard.Notice'), 'rgba(5,19,132,0.4)');
        $dataSources[] = Notice::get()->sortBy('created_at')->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('Ymd');
        });


        for ($i = -30; $i <= 0; $i++) {
            $date = Carbon::now()->addDays($i)->format('Ymd');
            $label[] = $date;

            foreach ($datasets as $key => $dataset) {
                $dataset->data[] = isset($dataSources[$key][$date]) ? $dataSources[$key][$date]->count() : 0;
            }
        }

        return [
            'label'     =>  $label,
            'datasets'  =>  $datasets,
        ];
    }
}
