<?php

namespace App\Application\Commands;

class DeleteUserCommand
{
    public function __construct(
        public readonly int $id
    ) {}
}