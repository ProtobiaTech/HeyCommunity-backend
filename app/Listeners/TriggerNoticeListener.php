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
        $Notice->initiator_user_id  =       Auth::user()->user()->id;
        $Notice->type_id            =       NoticeType::getIdByName($this->event->noticeTypeName);
        $Notice->entity_id          =       $this->event->entity->id;
        $Notice->entity_type        =       get_class($this->event->entity);
        $Notice->target_id          =       $this->event->target->id;
        $Notice->target_type        =       get_class($this->event->target);
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
        $userId = $this->event->target->author->wx_open_id;
        $templateId = env('WECHAT_TEMP_NOTICE_ID');
        $url = 'http://' . request()->header()['host'][0];
        $color = '#FF0000';
        $data = [
            'first'        =>  $this->getWechatNoticeFirst(),
            'subject'      =>  $this->getWechatNoticeSubject(),
            'sender'       =>  "HEY社区 机器人",
            'remark'       =>  '这是来自 ' . System::findOrFail(1)->community_name . ' 的消息，点击了解详情',
        ];
        $result = $notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
    }

    /**
     *
     */
    public function getWechatNoticeFirst()
    {
        $str = Auth::user()->user()->nickname . ': ';
        $noticeType = NoticeType::getIdByName($this->event->noticeTypeName);
        if ($noticeType == 10) {
            $str .= '喜欢 ❤️';
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
        $str = Auth::user()->user()->nickname . ' ';
        $noticeType = NoticeType::getIdByName($this->event->noticeTypeName);
        if ($noticeType == 10) {
            $str .= '喜欢你的公园动态';
        } else if ($noticeType == 11) {
            $str .= '评论了你的公园动态';
        } else if ($noticeType == 12) {
            $str .= '在公园动态中回复了你';
        }
        return $str;
    }
}
