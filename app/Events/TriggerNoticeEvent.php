<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Timeline;

class TriggerNoticeEvent extends Event
{
    use SerializesModels;

    /**
     *
     */
    public $timeline;

    /**
     *
     */
    public $noticeTypeName;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($entity, $target, $typeName)
    {
        $this->entity = $entity;
        $this->target = $target;
        $this->noticeTypeName = $typeName;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
