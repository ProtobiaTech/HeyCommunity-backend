<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Baum\Node;

class TopicNode extends Node
{
    use SoftDeletes;

    /**
     * Related TopicNode
     */
    public function childNodes()
    {
        return $this->hasMany('App\TopicNode', 'parent_id', 'id');
    }

    /**
     * Related TopicNode
     */
    public function parentNode()
    {
        return $this->belongsTo('App\TopicNode', 'parent_id', 'id');
    }

    /**
     * Related Topic
     */
    public function topics()
    {
        return $this->hasMany('App\Topic', 'topic_node_id');
    }

    /**
     * Root Nodes Scope
     */
    public function scopeRootNodes()
    {
        return $this->whereNull('parent_id');
    }
}
