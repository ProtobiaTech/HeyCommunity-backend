<?php

namespace App\Listeners;

use App\Events\ExtractKeywordsEvent;
use App\Helpers\ExtractKeywords;
use App\Keyword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExtractKeywordsListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  ExtractKeywordsEvent $event
     * @return void
     */
    public function handle(ExtractKeywordsEvent $event)
    {
        $object = $event->object;

        $keywords = ExtractKeywords::getKeywords($object->content, 5);

        foreach ($keywords as $word => $score) {
            $keyword = Keyword::firstOrNew(['name' => $word]);

            switch (get_class($object)) {
                case 'App\Timeline':
                    $keyword->timeline_count += 1;
                    $keyword->save();
                    $keyword->timelines()->attach($object->id);
                    break;
                case 'App\Topic':
                    $keyword->topic_count += 1;
                    $keyword->save();
                    $keyword->topics()->attach($object->id);
                    break;
            }
        }
    }
}
