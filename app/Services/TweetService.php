<?php

namespace App\Services;

use App\DTOs\CreateTweetDTO;
use App\DTOs\TweetDTO;
use App\DTOs\UserDTO;
use App\Models\Tweet;
use Carbon\Carbon;

class TweetService
{
    public function getAllTweets(): array
    {
        $tweets = Tweet::with(['user', 'likes'])
            ->orderBy('created_at', 'desc')
            ->get();

        return $tweets->map(function ($tweet) {
            return $this->toDTO($tweet);
        })->toArray();
    }

    public function createTweet(CreateTweetDTO $dto): TweetDTO
    {
        $tweet = Tweet::create([
            'content' => $dto->content,
            'user_id' => $dto->userId,
        ]);

        $tweet->load('user');

        return $this->toDTO($tweet);
    }

    public function likeTweet(int $tweetId, int $userId): array
    {
        $tweet = Tweet::findOrFail($tweetId);

        if (! $tweet->likes()->where('user_id', $userId)->exists()) {
            $tweet->likes()->create(['user_id' => $userId]);
        }

        return [
            'likes_count' => $tweet->likes()->count(),
            'liked_by_user' => true,
        ];
    }

    public function unlikeTweet(int $tweetId, int $userId): array
    {
        $tweet = Tweet::findOrFail($tweetId);
        $tweet->likes()->where('user_id', $userId)->delete();

        return [
            'likes_count' => $tweet->likes()->count(),
            'liked_by_user' => false,
        ];
    }

    private function toDTO(Tweet $tweet): TweetDTO
    {
        $user = $tweet->user;

        return new TweetDTO(
            id: $tweet->id,
            content: $tweet->content,
            user: new UserDTO(
                id: $user->id,
                firstname: $user->firstname,
                surname: $user->surname,
                email: $user->email
            ),
            likesCount: $tweet->likes->count(),
            likedByUser: $tweet->likedByUser(),
            createdAt: Carbon::parse($tweet->created_at)->diffForHumans()
        );
    }
}
