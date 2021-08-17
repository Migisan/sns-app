<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    /**
     * ホワイトリスト
     */
    protected $fillable = [
        'name',
    ];

    /**
     * articlesテーブル リレーション(子)
     * 
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Article')->withTimestamps();
    }

    /**
     * ハッシュタグ
     * 
     * @return string
     */
    public function getHashtagAttribute(): string
    {
        return '#' . $this->name;
    }
}
