<?php

namespace app\services\rbac;

use app\dto\AuthItemDto;
use app\repositories\AuthItemRepository;

class StoreAuthItemService
{
    private AuthItemRepository $repository;

    public function __construct(AuthItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AuthItemDto $dto)
    {
        $this->repository->store($dto);
    }
}