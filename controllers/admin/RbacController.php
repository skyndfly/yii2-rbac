<?php

namespace app\controllers\admin;


use app\dto\AuthItemDto;
use app\enums\RoleTypeEnum;
use app\services\rbac\PaginateRoleService;
use app\services\rbac\StoreAuthItemService;
use app\widgets\form\AuthItemCreateForm;
use Exception;
use Yii;

class RbacController extends BaseController
{
    private PaginateRoleService $paginateRoleService;
    private StoreAuthItemService $storeAuthItemService;

    public function __construct(
        $id,
        $module,
        PaginateRoleService $paginateRoleService,
        StoreAuthItemService $storeAuthItemService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->paginateRoleService = $paginateRoleService;
        $this->storeAuthItemService = $storeAuthItemService;
    }


    public function actionIndex()
    {
        $roles = $this->paginateRoleService->execute();
        return $this->render('index', ['dataProvider' => $roles]);
    }

    public function actionRoleCreate()
    {
        $form = new AuthItemCreateForm();
        $form->type = RoleTypeEnum::ROLE->value;
        return $this->render('role/create', ['form' => $form]);
    }

    public function actionRoleStore()
    {
        try {
            $form = new AuthItemCreateForm();
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $dto = new AuthItemDto(
                    $form->name,
                    $form->description,
                    RoleTypeEnum::from($form->type)
                );
                $this->storeAuthItemService->execute($dto);
                Yii::$app->session->setFlash('success', "Роль {$dto->name} добавлена");
                return $this->redirect('/lk/rbac/role/create');

            }
            echo "<pre>";
            print_r(11);
            echo "</pre>";
            die;

        } catch (Exception $exception) {
            Yii::$app->session->setFlash('error', $exception->getMessage());
            return $this->redirect('/lk/rbac/role/create');
        }
    }
}