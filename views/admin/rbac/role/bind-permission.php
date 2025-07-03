<?php

use app\widgets\form\BindPermissionToRoleForm;
use yii\bootstrap5\Html;
use yii\widgets\ActiveForm;

/** @var string $role */
/** @var BindPermissionToRoleForm $formModel */

$this->title = 'Привязать разрешение';
$this->params['breadcrumbs'] = [
    ['label' => 'Роли и разрешения', 'url' => '/lk/rbac'],
    ['label' => $role, 'url' => '/lk/rbac/role/view/' . $role],
    $this->title
];
?>
<section>
    <h1>Привязать разрешение</h1>
    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'action' => ['/lk/rbac/role/bind-permission'],

    ]) ?>
    <?= $form->field($formModel, 'role')->textInput([
        'readonly' => true,
    ]) ?>
    <?= $form->field($formModel, 'permissions')->checkboxList(
        $formModel->availablePermissions(),
        [
            'class' => 'multi_box',
            'item' => function ($index, $label, $name, $checked, $value) {
                return Html::tag(
                    'div',
                    Html::checkbox($name, $checked, [
                        'value' => $value,
                        'label' => $label,
                        'labelOptions' => ['class' => 'multi_checkbox'],
                    ]),
                    ['class' => 'checkbox_wrapper']
                );
            }
        ]
    ) ?>

    <?= Html::submitButton('Привязать', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end() ?>
</section>


