<?php

namespace App\Application\Commands;

class UpdateUserCommand
{
    public function __construct(
        public readonly int $id,
        public readonly string $nom,
        public readonly string $prenom,
        public readonly string $email,
        public readonly string $telephone
    ) {}
}