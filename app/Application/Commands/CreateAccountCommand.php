<?php

namespace App\Application\Commands;

class CreateAccountCommand
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $name,
    ) {}
}
