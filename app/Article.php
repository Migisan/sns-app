<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    /**
     * ホワイトリスト
     */
    protected $fillable = [
        'title',
        'body',
    ];

    /**
     * usersテーブル リレーション(親)
     * 
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    /**
     * likesテーブル リレーション(子)
     * 
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    /**
     * tagsテーブル リレーション(子)
     * 
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    /**
     * いいね済み判定
     * 
     * @param User
     * @return bool
     */
    public function isLikedBy(?User $user): bool
    {
        return $user ? (bool)$this->likes->where('id', $user->id)->count() : false;
    }

    /**
     * いいね数取得
     * 
     * @return int
     */
    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }
}
