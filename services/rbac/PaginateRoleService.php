<?php

namespace app\services\rbac;

use app\repositories\AuthItemRepository;
use yii\data\ArrayDataProvider;

class PaginateRoleService
{
    private AuthItemRepository $repository;
    private const int PAGINATE = 50;

    public function __construct(AuthItemRepository $repository)
    {
        $this->repository = $repository;
    }


    public function execute(): ArrayDataProvider
    {
        $roles = $this->repository->getAllRole();
        foreach ($roles as $item) {
            $item->countRelated = $this->repository->countRelated($item->name);
        }

        return new ArrayDataProvider([
            'allModels' => $roles,
            'pagination' => [
                'pageSize' => self::PAGINATE
            ]
        ]);

    }
}