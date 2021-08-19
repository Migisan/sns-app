<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Mail\BareMail;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * パスワード再設定
     * 
     * @param $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token, new BareMail()));
    }

    /**
     * articlesテーブル リレーション(子)
     * 
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany('App\Article');
    }

    /**
     * followsテーブル リレーション(フォローされる側)
     * 
     * @return BelongsToMany
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }

    /**
     * followsテーブル リレーション(フォローする側)
     * 
     * @return BelongsToMany
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }

    /**
     * likesテーブル リレーション
     * 
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\Article', 'likes')->withTimestamps();
    }

    /**
     * フォロー中判定
     * 
     * @param User
     * @return bool
     */
    public function isFollowedBy(?User $user): bool
    {
        return $user ? (bool)$this->followers->where('id', $user->id)->count() : false;
    }

    /**
     * フォロワー数取得
     * 
     * @return int
     */
    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }

    /**
     * フォロ数取得
     * 
     * @return int
     */
    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }
}
