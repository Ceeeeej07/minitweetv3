<?php

namespace App\DTOs;

class CreateTweetDTO
{
    public function __construct(
        public string $content,
        public int $userId
    ) {}
}
