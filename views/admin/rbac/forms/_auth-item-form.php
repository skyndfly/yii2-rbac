<?php
/** @var AuthItemCreateForm $model */

/** @var string $action */

use app\widgets\form\AuthItemCreateForm;
use yii\widgets\ActiveForm;
?>

<section>
    <?php $form = ActiveForm::begin([
        'id' => 'create-auth-item-form',
        'method' => 'post',
        'action' => [$action],
        'fieldConfig' => []
    ])
    ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'description') ?>
    <?= $form->field($model, 'type')->textInput([
        'readonly' => 'readonly',
        'value' => $model->type
    ]) ?>
    <div class="form-group">
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </div>
    <?php ActiveForm::end() ?>
</section>