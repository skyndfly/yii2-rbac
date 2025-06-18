<?php

namespace app\controllers\admin;


use app\services\rbac\PaginateRoleService;

class RbacController extends BaseController
{
    private PaginateRoleService $paginateRoleService;

    public function __construct(
        $id,
        $module,
        PaginateRoleService $paginateRoleService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->paginateRoleService = $paginateRoleService;
    }


    public function actionIndex()
    {
        $roles = $this->paginateRoleService->execute();
        return $this->render('index', ['dataProvider' => $roles]);
    }

    public function actionRoleCreate()
    {
        return $this->render('role/create');
    }
}