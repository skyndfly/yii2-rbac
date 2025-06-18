<?php

use app\enums\RoleTypeEnum;
use app\widgets\form\AuthItemCreateForm;

/** @var AuthItemCreateForm $form */
?>
    <h1>Создать <span style="text-transform: lowercase;"><?= RoleTypeEnum::from($form->type)->label() ?></span></h1>

<?=
$this->render('../forms/_auth-item-form', ['model' => $form, 'action' => '/lk/rbac/role/store']) ?>