<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use SoftDeletes;

    /**
     * Related User
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Related Initiator
     */
    public function initiator()
    {
        return $this->belongsTo('App\User', 'initiator_user_id');
    }

    /**
     * Related NoticeType
     */
    public function type()
    {
        return $this->belongsTo('App\NoticeType', 'type_id');
    }

    /**
     * Related Entity
     */
    public function entity()
    {
        return $this->morphTo()->withTrashed();
    }

    /**
     * Related Entity
     */
    public function target()
    {
        return $this->morphTo()->withTrashed();
    }
}
