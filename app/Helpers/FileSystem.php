<?php

namespace App\Helpers;

class FileSystem
{
    public static function getFullUrl($url)
    {
        if ($url && substr($url, 0, 4) !== 'http') {
            if (env('FILESYSTEM_DEFAULT') === 'qiniu' && env('QINIU_DOMAINS_CUSTOM')) {
                return env('QINIU_DOMAINS_CUSTOM') . '/' . $url;
            } else {
                if (isset($_SERVER['REQUEST_SCHEME'])) {
                    return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/' . $url;
                } else {
                    return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $url;
                }
            }
        } else {
            return $url;
        }
    }
}
