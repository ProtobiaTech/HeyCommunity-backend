<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['site_name', 'domain', 'email', 'phone'];
}
