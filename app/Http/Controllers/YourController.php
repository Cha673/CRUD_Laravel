<?php

namespace App\Http\Controllers;

use App\Repositories\ModelRepository;

class YourController extends Controller
{
    protected $repository;

    public function __construct(ModelRepository $repository)
    {
        $this->repository = $repository;
    }
}