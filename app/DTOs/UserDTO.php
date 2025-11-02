<?php

namespace App\DTOs;

class UserDTO
{
    public function __construct(
        public int $id,
        public string $firstname,
        public string $surname,
        public string $email
    ) {}
}
