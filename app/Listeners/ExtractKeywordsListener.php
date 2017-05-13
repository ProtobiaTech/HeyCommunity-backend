<?php

namespace App\Listeners;

use App\Events\ExtractKeywordsEvent;
use App\TopicKeywords;
use App\TimelineKeyWords;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExtractKeywordsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExtractKeywordsEvent  $event
     * @return void
     */
    public function handle(ExtractKeywordsEvent $event)
    {
        $params     = $event->params;

        $type       = $params['type'];
        $content    = $params['content'];
        $id         = $params['id'];

        try {
            switch ($type) {
                case 1:
                    $this->storeTimelineKeywords($content, $id);
                    break;
                case 2:
                    $this->storeTopicKeywords($content, $id);
                    break;
            }
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
    }

    private function storeTimelineKeywords($content, $id)
    {
        $keywords   = \App\Helpers\ExtractKeywords::getKeywords($content);

        foreach ($keywords as $keyword => $score) {
            $timelineKeyword   = new TimelineKeyWords;
            $timelineKeyword->timeline_id   = $id;
            $timelineKeyword->keyword       = $keyword;
            $timelineKeyword->score         = $score;
            $timelineKeyword->save();
        }
    }

    private function storeTopicKeywords($content, $id)
    {
        $keywords   = \App\Helpers\ExtractKeywords::getKeywords($content);

        foreach ($keywords as $keyword => $score) {
            $topicKeyword   = new TopicKeywords;
            $topicKeyword->topic_id     = $id;
            $topicKeyword->keyword      = $keyword;
            $topicKeyword->score        = $score;
            $topicKeyword->save();
        }
    }
}
