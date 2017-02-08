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
    public static function getImgUrl($url)
    {
        $pattern = '/^http[s]?:\/\/.*/';
        if (preg_match($pattern, $url)) {
            return $url;
        } else {
            // $domain = '//public.hey-community.cn/';
            $domain = '';
            return $domain . $url;
        }
    }

    /**
     *
     */
    public function getUriAttribute($uri)
    {
        if (substr($uri, 0, 4) !== 'http' && env('FILESYSTEM_DEFAULT') === 'qiniu' && env('QINIU_DOMAINS_CUSTOM')) {
            return env('QINIU_DOMAINS_CUSTOM') . '/' . $uri;
        } else {
            return $uri;
        }
    }
}
