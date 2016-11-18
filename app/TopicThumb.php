<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicThumb extends Model
{
    use SoftDeletes;

    /**
     *
     */
    const VALUE_UP = 1;

    /**
     *
     */
    const VALUE_DOWN = 2;

    /**
     * Related User
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Related User
     */
    public function topic()
    {
        return $this->belongsTo('App\Topic', 'topic_id');
    }
}
