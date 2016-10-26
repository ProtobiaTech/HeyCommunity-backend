<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use AuraIsHere\LaravelMultiTenant\Traits\TenantScopedModelTrait;

class TenantInfo extends Model
{
    use SoftDeletes;
    use TenantScopedModelTrait;

    /**
     *
     */
    public function tenant()
    {
        return $this->belongsTo('App\Tenant', 'tenant_id');
    }
}
