<?php

use app\dto\AuthItemDto;
use app\enums\RoleTypeEnum;
use rmrevin\yii\fontawesome\FAS;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var ArrayDataProvider $dataProvider */
?>
<section>
    <h1>Список ролей</h1>
    <a href="/lk/rbac/role/create" class="btn btn-outline-success mb-3">Создать роль</a>
    <a href="/lk/rbac/permission/create" class="btn btn-outline-success mb-3">Создать разрешение</a>
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
                },
            ],
            [
                'attribute' => 'countRelated',
                'label' => 'Кол-во отношений',
                'format' => 'raw',
                'value' => function (AuthItemDto $item) {
                    if ($item->type === RoleTypeEnum::ROLE){
                        if ($item->countRelated > 0) {
                            return Html::a(
                                $item->countRelated,
                                ["/lk/rbac/role/view/{$item->name}"]
                            );
                        }
                        return $item->countRelated;
                    }
                }
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            FAS::icon('eye'),
                            ["/lk/rbac/role/view/{$model->name}"]
                        );
                    }
                ]
            ]
        ]
    ]) ?>
</section>

