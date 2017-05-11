<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeyCommunity extends Model
{
    use SoftDeletes;

    /**
     *
     */
    public function socopeLatest()
    {
        return $this->orderByDesc(['updated_at', ['id']]);
    }
}
