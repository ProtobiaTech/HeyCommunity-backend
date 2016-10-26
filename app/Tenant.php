<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use SoftDeletes;

    /**
     *
     */
    public function info()
    {
        $this->hasOne('App\TenantInfo');
    }
}
