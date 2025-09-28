<?php

namespace App\Application\Commands;

class CreateUserCommand
{
    public function __construct(
        public readonly string $nom,
        public readonly string $prenom,
        public readonly string $email,
        public readonly string $telephone
    ) {}
}