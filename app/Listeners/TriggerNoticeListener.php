<?php

namespace App\Listeners;

use App\Events\TriggerNoticeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Auth;
use App\Notice;
use App\NoticeType;

class TriggerNoticeListener
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
     * @param  TriggerNoticeEvent  $event
     * @return void
     */
    public function handle(TriggerNoticeEvent $event)
    {
        $Notice = new Notice();
        $Notice->user_id            =       $event->entity->user_id;
        $Notice->initiator_user_id  =       Auth::user()->id;
        $Notice->type_id            =       NoticeType::getIdByName($event->noticeTypeName);
        $Notice->entity_id          =       $event->entity->id;
        $Notice->entity_type        =       get_class($event->entity);
        $Notice->save();
    }
}
