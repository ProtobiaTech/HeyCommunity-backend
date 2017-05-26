<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeline extends HeyCommunity
{
    /**
     * Related User
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Related TimelineLike
     */
    public function author_like()
    {
        return $this->hasMany('App\TimelineLike')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     * Related Comments
     */
    public function comments()
    {
        return $this->hasMany('App\TimelineComment', 'timeline_id')->orderBy('created_at', 'desc')->with('author', 'parent');
    }

    /**
     * Related Notice
     */
    public function notices()
    {
        return $this->morphMany('App\Notice', 'noticeable');
    }

    /**
     *
     */
    public function images()
    {
        return $this->hasMany('App\TimelineImg', 'timeline_id');
    }

    /**
     * Keyword
     */
    public function keywords()
    {
        return $this->morphMany('App\Keyword', 'keywordable');
    }

    /**
     *
     */
    public function getImgs()
    {
        return TimelineImg::getImgs($this->imgs);
    }

    /**
     *
     */
    public function getVideoAttribute($url)
    {
        return \App\Helpers\FileSystem::getFullUrl($url);
    }

    /**
     *
     */
    public function getPosterAttribute($url)
    {
        return \App\Helpers\FileSystem::getFullUrl($url);
    }
}
