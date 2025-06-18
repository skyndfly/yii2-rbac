<?php

namespace app\services\rbac;

use app\repositories\RbacRepository;
use yii\data\ArrayDataProvider;

class PaginateRoleService
{
    private RbacRepository $repository;
    private const int PAGINATE = 10;

    public function __construct(RbacRepository $repository)
    {
        $this->repository = $repository;
    }


    public function execute(): ArrayDataProvider
    {
        $roles = $this->repository->getAllRole();

        return new ArrayDataProvider([
            'allModels' => $roles,
            'pagination' => [
                'pageSize' => self::PAGINATE
            ]
        ]);

    }
}