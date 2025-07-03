<?php
/** @var AuthItemCreateForm $form */

use app\enums\RoleTypeEnum;
use app\widgets\form\AuthItemCreateForm;

$this->title = 'Создать роль';
$this->params['breadcrumbs'] = [
    ['label' => 'Роли и разрешения', 'url' => '/lk/rbac'],
    $this->title
];
?>
    <h1>Создать <span style="text-transform: lowercase;"><?= RoleTypeEnum::from($form->type)->label() ?></span></h1>


<?=
$this->render('../forms/_auth-item-form', ['model' => $form, 'action' => '/lk/rbac/role/store']) ?>