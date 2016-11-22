<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicNode extends Model
{
    use SoftDeletes;

    /**
     * Related TopicNode
     */
    public function childNodes()
    {
        return $this->hasMany('App\TopicNode', 'parent_id', 'id');
    }
}
