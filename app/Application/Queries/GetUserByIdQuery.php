<?php

namespace App\Application\Queries;

class GetUserByIdQuery
{
    public function __construct(
        public readonly int $id
    ) {}
}