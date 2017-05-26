<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{

    protected $guarded = [];

    public function timelines()
    {
        return $this->morphedByMany('App\Timeline', 'keywordable');
    }

    public function topics()
    {
        return $this->morphedByMany('App\Topic', 'keywordable');
    }
}
