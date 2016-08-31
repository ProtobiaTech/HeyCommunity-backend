<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NoticeType extends Model
{
    use SoftDeletes;

    /**
     *
     */
    public static $types = [
        ['id' => 10, 'name' => 'timeline_like'],
        ['id' => 11, 'name' => 'timeline_comment'],
        ['id' => 12, 'name' => 'timeline_comment_comment'],

        ['id' => 20, 'name' => 'topic_like'],
        ['id' => 21, 'name' => 'topic_comment'],
        ['id' => 22, 'name' => 'topic_comment_comment'],
    ];

    /**
     *
     */
    public static function getIdByName($name)
    {
        foreach (self::$types as $type) {
            if ($type['name'] === $name) {
                return $type['id'];
            }
        }
    }
}
