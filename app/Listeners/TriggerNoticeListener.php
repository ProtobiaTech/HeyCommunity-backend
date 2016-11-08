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
        $this->event = $event;

        $Notice = new Notice();
        $Notice->user_id            =       $this->event->target->user_id;
        $Notice->initiator_user_id  =       Auth::user()->id;
        $Notice->type_id            =       NoticeType::getIdByName($this->event->noticeTypeName);
        $Notice->entity_id          =       $this->event->entity->id;
        $Notice->entity_type        =       get_class($this->event->entity);
        $Notice->target_id          =       $this->event->target->id;
        $Notice->target_type        =       get_class($this->event->target);
        $Notice->save();

        // send wechat notice
        if ($this->event->target->author->wx_open_id) {
            //@todo $this->sendWechatNotice();
        }
    }
}
