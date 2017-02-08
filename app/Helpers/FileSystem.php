<?php

namespace App\Helpers;

class FileSystem
{
    public static function getFullUrl($url)
    {
        if ($url && substr($url, 0, 4) !== 'http' && env('FILESYSTEM_DEFAULT') === 'qiniu' && env('QINIU_DOMAINS_CUSTOM')) {
            return env('QINIU_DOMAINS_CUSTOM') . '/' . $url;
        } else {
            return $url;
        }
    }
}
