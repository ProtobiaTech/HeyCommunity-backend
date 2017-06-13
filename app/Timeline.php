<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Nicolaslopezj\Searchable\SearchableTrait;

class Timeline extends HeyCommunity
{
    use SearchableTrait;

    protected $appends = ['isLike'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'timelines.content'    => 10,
        ],
    ];

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
        return $this->morphToMany('App\Keyword', 'keywordable');
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

    /**
     *
     */
    public function getIsLikeAttribute()
    {
        if (Auth::user()->check()) {
            return $this->author_like->where('user_id', Auth::user()->user()->id)->count();
        }

        return false;
    }
}
