<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tweet extends Model
{
    protected $fillable = ['content'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(TweetLike::class);
    }

    public function likedByUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
