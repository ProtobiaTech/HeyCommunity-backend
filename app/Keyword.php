<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{

    protected $guarded = [];

    public function scopeOfType($query, $column, $number = 8)
    {
        return $query->latest($column)->where($column, '>', 0)->take($number)->get()->shuffle();
    }

    public function timelines()
    {
        return $this->morphedByMany('App\Timeline', 'keywordable');
    }

    public function topics()
    {
        return $this->morphedByMany('App\Topic', 'keywordable');
    }
}
