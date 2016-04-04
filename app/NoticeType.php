<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use AuraIsHere\LaravelMultiTenant\Traits\TenantScopedModelTrait;

class NoticeType extends Model
{
    use SoftDeletes;
    use TenantScopedModelTrait;

}
