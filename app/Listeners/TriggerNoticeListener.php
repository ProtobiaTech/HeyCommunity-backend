<?php

namespace App\Listeners;

use App\Events\TriggerNoticeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use EasyWeChat\Foundation\Application;

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

        // save notice in db
        $Notice = new Notice();
        $Notice->user_id            =       $this->event->target->user_id;
        $Notice->initiator_user_id  =       Auth::user()->id;
        $Notice->type_id            =       NoticeType::getIdByName($this->event->noticeTypeName);
        $Notice->entity_id          =       $this->event->target->id;
        $Notice->entity_type        =       get_class($this->event->target);
        $Notice->save();

        // send wechat notice
        if ($this->event->target->author->wx_open_id) {
            $this->sendWechatNotice();
        }
    }

    /**
     *
     */
    public function sendWechatNotice()
    {
        $options = [
            'debug'     => true,
            'app_id'    => env('WECHAT_APPID'),
            'secret'    => env('WECHAT_SECRET'),
        ];

        $app = new Application($options);
        $notice = $app->notice;

        $userId = $this->event->entity->author->wx_open_id;
        $templateId = '2tyXWaj3fRdWxpYtUDEbKtSpEoVWSgKe_QSclp986jI';
        if (Auth::user()->tenant->domain) {
            $url = 'http://' . Auth::user()->tenant->domain;
        } else {
            $url = 'http://' . Auth::user()->tenant->sub_domain;
        }
        $color = '#FF0000';

        $data = [
            'first'        =>  $this->getWechatNoticeFirst(),
            'subject'      =>  $this->getWechatNoticeSubject(),
            'sender'       =>  "HeyCommunity Robot",
            'remark'       =>  '这是来自 ' . Auth::user()->tenant->site_name . ' 的消息，点击了解详情',
        ];

        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
    }

    /**
     *
     */
    public function getWechatNoticeFirst()
    {
        $str = Auth::user()->nickname . ': ';
        $noticeType = NoticeType::getIdByName($this->event->noticeTypeName);
        if ($noticeType == 10) {
            $str .= 'I Like Your Timeline';
        } else if ($noticeType == 11) {
            $str .= $this->event->entity->content;
        } else if ($noticeType == 12) {
            $str .= $this->event->entity->content;
        }
        return $str;
    }

    /**
     *
     */
    public function getWechatNoticeSubject()
    {
        $str = Auth::user()->nickname . ' ';
        $noticeType = NoticeType::getIdByName($this->event->noticeTypeName);
        if ($noticeType == 10) {
            $str .= 'Like Your Timeline';
        } else if ($noticeType == 11) {
            $str .= 'Comment Your Timeline';
        } else if ($noticeType == 12) {
            $str .= 'Reply Your Timeline Comment';
        }
        return $str;
    }
}
