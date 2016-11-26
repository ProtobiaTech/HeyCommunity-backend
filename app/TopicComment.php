<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use AuraIsHere\LaravelMultiTenant\Traits\TenantScopedModelTrait;

class TopicComment extends Model
{
    use SoftDeletes;
    use TenantScopedModelTrait;

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

    /**
     * Related TopicComment
     */
    public function parent()
    {
        return $this->belongsTo('App\TopicComment', 'parent_id')->with('author');
    }
}
