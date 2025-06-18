<?php

use app\dto\AuthItemDto;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var ArrayDataProvider $dataProvider */
?>
<section>
    <h1>Список ролей</h1>
    <a href="/lk/rbac/role/create" class="btn btn-outline-success mb-3">Создать роль</a>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{summary}\n{pager}",
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'Название',
                'filter' => true,
            ],
            [
                'attribute' => 'description',
                'label' => 'Описание'
            ],
            [
                'attribute' => 'type',
                'label' => 'Тип роли',
                'value' => function (AuthItemDto $item) {
                    return $item->type->label();
                }
            ],
            [
                    'class' => ActionColumn::class,
                    'template' => '{view} {update} {delete}',
            ]
        ]
    ]) ?>
</section>

