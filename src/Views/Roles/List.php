<?php

use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\rbac\Role;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ArrayDataProvider $rolesDataProvider
 */

?>
<div>
    <h2><?= $this->title ?></h2>
</div>

<div>
    <p>
        <a href="<?= Url::toRoute('roles/create') ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Новая роль</a>
        <a href="<?= Url::toRoute('constants/update-storage') ?>" class="btn btn-default"><i class="glyphicon glyphicon-th-list"></i> Обновить список констант</a>
    </p>
</div>

<?= GridView::widget([
    'dataProvider' => $rolesDataProvider,
    'layout' => "{items}",
    'columns' => [
        [
            'class' => EditableColumn::class,
            'attribute' => 'name',
            'label' => 'Название',
            'editableOptions' => [
                'name' => 'name',
                'formOptions' => ['action' => ['/roles/update']],
            ],
        ],
        [
            'class' => EditableColumn::class,
            'attribute' => 'description',
            'label' => 'Описание',
            'value' => function(Role $role) {
                return $role->description ?: '';
            },
            'editableOptions' => [
                'name' => 'description',
                'formOptions' => ['action' => ['/roles/update']],
            ],
        ],
        [
            'attribute' => 'createdAt',
            'label' => 'Дата создания',
            'value' => function(Role $role) {
                return $role->createdAt ? date('d.m.Y H:i:s', $role->createdAt) : null;
            }
        ],
        [
            'attribute' => 'updatedAt',
            'label' => 'Дата редактирования',
            'value' => function(Role $role) {
                return $role->updatedAt ? date('d.m.Y H:i:s', $role->updatedAt) : null;
            }
        ],
        [
            'class' => \kartik\grid\ActionColumn::class,
            'header' => '',
            'template' => '{delete}',
        ],
    ],
]) ?>
