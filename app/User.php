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
     * The user's following list
     */
    public function following()
    {
        return $this->belongsToMany('App\User', 'user_relationship', 'from_user_id', 'to_user_id')
                    ->withTimestamps();
    }

    /**
     * The user's follower list
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_relationship', 'to_user_id', 'from_user_id')
                    ->withTimestamps();
    }

    /**
     * The user's relationship
     */
    public function userRelationship()
    {
        return $this->hasMany('App\UserRelationship', 'from_user_id');
    }

    /*
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

    /**
     * Is someone followed by current user?
     * @param int $toUserId
     */
    public function isFollowed($toUserId)
    {
        $relationship = $this->userRelationship()
                            ->where('to_user_id', $toUserId)
                            ->first();
        return $relationship ? true : false;
    }

    /**
     * Is someone blocked by current user?
     * @param int $toUserId
     */
    public function isBlocked($toUserId)
    {
        $relationship = $this->userRelationship()
                            ->where('to_user_id', $toUserId)
                            ->where('is_block', UserRelationship::BLOCKED)
                            ->first();
        return $relationship ? true : false;
    }

    /**
     * Block someone
     * @param int $toUserId
     */
    public function toBlock($toUserId)
    {
        $relationship = UserRelationship::where([
                'from_user_id' => $this->id,
                'to_user_id' => $toUserId,
            ])
            ->first();
        if (!$relationship) {
            $relationship = new UserRelationship;
            $relationship->from_user_id = $this->id;
            $relationship->to_user_id = $toUserId;
            $relationship->is_block = UserRelationship::BLOCKED;
        } else {
            $relationship->is_block = UserRelationship::BLOCKED;
        }
        return $relationship->save();
    }

    /**
     * Unblock someone
     * @param int $userId
     */
    public function unBlock($userId)
    {
        $relationship = UserRelationship::where([
                'from_user_id' => $this->id,
                'to_user_id' => $userId,
            ])
            ->firstOrFail();
        $relationship->is_block = UserRelationship::UNBLOCKED;
        return $relationship->save();
    }

    /**
     * Get block list
     */
    public function getBlock()
    {
        $relationship = $this->userRelationship()
                            ->where('from_user_id', $this->id)
                            ->where('is_block', UserRelationship::BLOCKED)
                            ->get();
        $relationship = $relationship->map(function($item){
            return $item->toUser;
        });
        return $relationship;
    }
}
