<?php

namespace App\DTO;

class UserDTO
{
    public function __construct(
        public int $telegram_id,
        public string $name,
        public bool $subscribed = true
    ) {}
}
