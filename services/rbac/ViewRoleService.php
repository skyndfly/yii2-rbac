<?php

namespace app\services\rbac;

use app\repositories\AuthAssignmentRepository;
use yii\data\ArrayDataProvider;

class ViewRoleService
{
    private AuthAssignmentRepository $authAssignmentRepository;
    private const int PAGINATE = 50;
    public function __construct(AuthAssignmentRepository $authAssignmentRepository)
    {
        $this->authAssignmentRepository = $authAssignmentRepository;
    }


    public function execute(string $roleName): ArrayDataProvider
    {
        return new ArrayDataProvider([
            'allModels' => $this->authAssignmentRepository->getByName($roleName),
            'pagination' => [
                'pageSize' => self::PAGINATE
            ]
        ]);
    }
}