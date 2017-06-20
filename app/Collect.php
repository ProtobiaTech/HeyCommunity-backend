<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    /**
     * types
     */
    public static $types = [
        1   =>  '封闭',
        2   =>  '私密',
    ];

    /**
     *
     */
    protected $guarded = ['id'];
}
