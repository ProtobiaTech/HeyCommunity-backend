<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Moment extends Model
{
    /**
     * types
     */
    public static $types = [
        1   =>  'images',
        2   =>  'gif',
    ];
}
