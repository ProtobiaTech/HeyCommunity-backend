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

        // send app push
        $this->sendAppPush($Notice);
    }

    /**
     *
     */
    public function sendAppPush($Notice)
    {
        if (env('JIGUANG_ENABLE')) {
            $alias = 'u' . $Notice->user_id;
            $notification = $this->getAppPushNotification($Notice);

            $JPush = new \JPush\Client(env('JIGUANG_APPKEY'), env('JIGUANG_SECRET'), storage_path('logs/jpush.log'));
            $push = $JPush->push();
            $push->setPlatform('all')->addAlias($alias);
            $push->options(['apns_production' => true]);
            $push->setNotificationAlert($notification);

            try {
                $push->send();
            } catch (\JPush\Exceptions\JPushException $e) {
                \Log::error($e);
            }
        } else {
        }
    }

    /**
     *
     */
    public function getAppPushNotification($Notice)
    {
        $notification = $Notice->initiator->nickname;
        $hasContent = true;

        switch ($Notice->type->name) {
            case 'timeline_like':
                $notification .= trans('notice.Like Your Timeline');
                $hasContent = false;
                break;
            case 'timeline_comment':
                $notification .= trans('notice.Comment Your Timeline: ');
                break;
            case 'timeline_comment_comment':
                $notification .= trans('notice.Reply Your TimelineComment: ');
                break;
            case 'topic_like':
                $notification .= trans('notice.Like Your Topic');
                $hasContent = false;
                break;
            case 'topic_comment':
                $notification .= trans('notice.Comment Your Topic: ');
                break;
            case 'topic_comment_comment':
                $notification .= trans('notice.Reply Your TopicComment: ');
                break;
        }

        if ($hasContent) {
            $notification .= mb_substr($Notice->entity->content, 0, 50, 'UTF-8');
        }

        return $notification;
    }

    /**
     *
     */
    public function sendWechatNotice()
    {
        $options = [
            'debug'     => true,
            'app_id'    => env('WECHATPA_APPID'),
            'secret'    => env('WECHATPA_SECRET'),
        ];
        $app = new Application($options);
        $notice = $app->notice;
        $userId = $this->event->target->author->wx_open_id;
        $templateId = env('WECHATPA_TEMP_NOTICE_ID');
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
