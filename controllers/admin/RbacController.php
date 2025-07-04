<?php

namespace app\controllers\admin;


use app\dto\AuthItemDto;
use app\enums\RoleTypeEnum;
use app\services\rbac\BindPermissionToRoleService;
use app\services\rbac\PaginateRoleService;
use app\services\rbac\StoreAuthItemService;
use app\services\rbac\ViewRoleService;
use app\widgets\form\AuthItemCreateForm;
use app\widgets\form\BindPermissionToRoleForm;
use DomainException;
use Exception;
use Yii;

class RbacController extends BaseController
{
    private PaginateRoleService $paginateRoleService;
    private StoreAuthItemService $storeAuthItemService;
    private ViewRoleService $viewRoleService;
    private BindPermissionToRoleService $bindPermissionToRoleService;

    public function __construct(
        $id,
        $module,
        PaginateRoleService $paginateRoleService,
        StoreAuthItemService $storeAuthItemService,
        ViewRoleService $viewRoleService,
        BindPermissionToRoleService $bindPermissionToRoleService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->paginateRoleService = $paginateRoleService;
        $this->storeAuthItemService = $storeAuthItemService;
        $this->viewRoleService = $viewRoleService;
        $this->bindPermissionToRoleService = $bindPermissionToRoleService;
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

    public function actionPermissionCreate()
    {
        $form = new AuthItemCreateForm();
        $form->type = RoleTypeEnum::PERMISSION->value;
        return $this->render('permission/create', ['form' => $form]);
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
                $typeLabel = RoleTypeEnum::from($form->type)->label();
                Yii::$app->session->setFlash('success', "{$typeLabel} {$dto->name} добавлена");
                return $this->redirect('/lk/rbac');

            }
            throw new DomainException('Произошла непредвиденная ошибка.');

        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect('/lk/rbac/role/create');
        }
    }

    public function actionRoleView(string $role)
    {
        $items = $this->viewRoleService->execute($role);
        return $this->render('role/view', [
            'role' => $role,
            'dataProvider' => $items,
            'permissions' => Yii::$app->getAuthManager()->getPermissionsByRole($role),
        ]);

    }

    public function actionBindPermissionToRole(string $role)
    {
        $form = new BindPermissionToRoleForm(['role' => $role]);

        return $this->render('role/bind-permission', [
            'role' => $role,
            'formModel' => $form,
        ]);

    }

    public function actionStorePermissionToRole()
    {
        $post = Yii::$app->request->post();
        try {
            if (empty($post['BindPermissionToRoleForm']['permissions'])) {
                $post['BindPermissionToRoleForm']['permissions'] = [];
            }
            $form = new BindPermissionToRoleForm();
            if ($form->load($post) && $form->validate()) {
                $this->bindPermissionToRoleService->execute($form->role, $form->permissions);
                Yii::$app->session->setFlash('success', 'Успешно');
                $this->redirect("/lk/rbac/role/view/{$form->role}");
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
            $this->redirect("/lk/rbac/role/{$post['BindPermissionToRoleForm']['role']}/bind-permission");
        }

    }
}