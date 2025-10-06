<?php

namespace App\Application\Commands;

class DeleteAccountCommand
{
    public function __construct(
        public readonly int $id
    ) {}
}
