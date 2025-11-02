<?php

namespace App\DTOs;

class TweetDTO
{
    public function __construct(
        public int $id,
        public string $content,
        public UserDTO $user,
        public int $likesCount,
        public bool $likedByUser,
        public string $createdAt
    ) {}
}
