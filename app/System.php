<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['wx_app_id', 'wx_app_secret', 'wx_temp_notice_id', 'enable_wechat_pa', 'created_at', 'updated_at', 'deleted_at'];
}
