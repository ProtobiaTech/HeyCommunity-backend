<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineVideo extends Model
{
    /**
     *
     */
    public function getUriAttribute($url)
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
