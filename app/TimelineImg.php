<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineImg extends Model
{
    use SoftDeletes;

    /**
     *
     */
    public static function getImgs($imgs)
    {
        $imgs = json_decode($imgs);
        if (is_array($imgs)) {
            $ret = [];
            foreach ($imgs as $imgId) {
                $ret[] = TimelineImg::findOrFail($imgId);
            }
            return $ret;
        } else {
            return [];
        }
    }

    /**
     *
     */
    public function getUriAttribute($url)
    {
        return \App\Helpers\FileSystem::getFullUrl($url);
    }
}
