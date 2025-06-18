<?php
/** @var AuthItemCreateForm $form */

use app\widgets\form\AuthItemCreateForm;

?>
    <h1>Создать новую роль</h1>


<?=
$this->render('../forms/_auth-item-form', ['model' => $form, 'action' => '/lk/rbac/role/store']) ?>