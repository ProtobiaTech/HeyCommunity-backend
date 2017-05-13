<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicKeywords extends Model
{
    use SoftDeletes;

    public function timelines()
    {
        return $this->belongsToMany(Timeline::clsss , 'timeline_keywords', 'timeline_id', 'timeline_keyword_id');
    }
}
