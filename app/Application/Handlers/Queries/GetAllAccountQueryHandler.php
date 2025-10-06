<?php

namespace App\Application\Handlers\Queries;

use App\Persistence\Interfaces\AccountRepositoryInterface;

class GetAllAccountQueryHandler
{
    public function __construct(private AccountRepositoryInterface $repository) {}

    public function handle(): array
    {
        return $this->repository->getAll();
    }
}
