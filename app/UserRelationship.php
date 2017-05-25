<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRelationship extends Model
{
    use SoftDeletes;

    const BLOCKED = 1;
    const UNBLOCKED = 0;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_relationship';

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'to_user_id');
    }
}
