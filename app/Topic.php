<?php

namespace App;

use Auth;
use App\Filters\TopicFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

class Topic extends Model
{
    use SoftDeletes;
    use TopicFilters;
    use SearchableTrait;

    protected $appends = ['thumb_value', 'is_star'];

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
            'topics.title'      => 10,
            'topics.content'    => 10,
        ],
    ];


    /**
     * Related Node
     */
    public function node()
    {
        return $this->belongsTo('App\TopicNode', 'topic_node_id');
    }

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

    /**
     * Related TopicThumb
     */
    public function thumbs()
    {
        return $this->hasMany('App\TopicThumb', 'topic_id')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     * Related TopicThumb
     */
    public function stars()
    {
        return $this->hasMany('App\TopicStar', 'topic_id')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     * Related Keyword
     */
    public function keywords()
    {
        return $this->morphToMany('App\Keyword', 'keywordable');
    }

    /**
     *
     */
    public function getThumbValueAttribute()
    {
        if (Auth::user()->check()) {
            $thumb = $this->thumbs->where('user_id', Auth::user()->user()->id)->first();

            if ($thumb) {
                return $thumb->value;
            }
        }

        return 0;
    }

    /**
     *
     */
    public function getIsStarAttribute()
    {
        if (Auth::user()->check()) {
            return $this->stars->where('user_id', Auth::user()->user()->id)->count();
        }

        return false;
    }
}
