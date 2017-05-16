<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model
{
    /**
     * types
     */
    public static $types = [
        1       =>      'friend',
        2       =>      'foe',
    ];
}
