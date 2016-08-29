<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimelineImg extends Model
{
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
            return $imgs;
        }
    }
}
