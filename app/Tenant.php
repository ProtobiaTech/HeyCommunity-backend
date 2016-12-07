<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Auth\Passwords\CanResetPassword;
use Kbwebs\MultiAuth\PasswordResets\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
// use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Kbwebs\MultiAuth\PasswordResets\Contracts\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'enable_wechat_pa', 'email', 'phone', 'created_at', 'updated_at', 'deleted_at'];

    /**
     *
     */
    public function info()
    {
        return $this->hasOne('App\TenantInfo');
    }

    /**
     *
     */
    public static function getWeChatAppId()
    {
        $Tenant = $GLOBALS['Tenant'];
        if ($Tenant->enable_wechat_pa) {
            return $Tenant->info->wx_app_id;
        } else {
            return env('WECHATPA_APPID');
        }
    }

    /**
     *
     */
    public static function getWeChatAppSecret()
    {
        $Tenant = $GLOBALS['Tenant'];
        if ($Tenant->enable_wechat_pa) {
            return $Tenant->info->wx_app_secret;
        } else {
            return env('WECHATPA_SECRET');
        }
    }

    /**
     *
     */
    public static function getWechatTempNoticeId()
    {
        $Tenant = $GLOBALS['Tenant'];
        if ($Tenant->enable_wechat_pa && $Tenant->info->wx_temp_notice_id) {
            return $Tenant->info->wx_temp_notice_id;
        } else {
            return env('WECHATPA_TEMP_NOTICE_ID');
        }
    }
}
