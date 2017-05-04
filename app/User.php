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

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'wx_open_id'];

    public function topics()
    {
        return $this->hasMany('App\Topic', 'user_id')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     * Related Timeline
     */
    public function timelines()
    {
        return $this->hasMany('App\Timeline', 'user_id')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     * Related TimelineLike
     */
    public function timelineLikes()
    {
        return $this->hasMany('App\TimelineLike', 'user_id')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     * Related TimelineComment
     */
    public function timelineComments()
    {
        return $this->hasMany('App\TimelineComment', 'user_id')->orderBy('created_at', 'desc')->with('author');
    }

    /**
     *
     */
    public static function getAvatarUrl($url)
    {
        return TimelineImg::getImgUrl($url);
    }


    /**
     *
     */
    public static function getGenderName($v)
    {
        $name = '保密';
        switch ($v) {
            case 1:
                $name = '男';
                break;
            case 2:
                $name = '女';
                break;
            default:
                $name = '保密';
                break;
        }
        return $name;
    }

    /**
     *
     */
    public function getAvatarAttribute($url)
    {
        return \App\Helpers\FileSystem::getFullUrl($url);
    }
}
