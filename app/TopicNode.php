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
    public function topics()
    {
        return $this->hasMany('App\Topic', 'topic_node_id');
    }
}
