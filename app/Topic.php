<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
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
     * Related TopicComment
     */
    public function comments()
    {
        return $this->hasMany('App\TopicComment', 'topic_id')->orderBy('created_at', 'desc')->with('author', 'parent');
    }
}
