<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TweetLike extends Model
{
    protected $fillable = ['user_id', 'tweet_id'];
}
