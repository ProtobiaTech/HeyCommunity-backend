<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use AuraIsHere\LaravelMultiTenant\Traits\TenantScopedModelTrait;

class Timeline extends Model
{
    use TenantScopedModelTrait;
}
