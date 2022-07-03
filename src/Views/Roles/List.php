<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ArrayDataProvider $rolesDataProvider
 * @var string $gridViewColumns
 * @var string $gridLayout
 * @var string $createPageRoute
 * @var string $updateConstantsRoute
 * @var bool $updateConstantsBtnAvailable
 */

?>
<div>
    <h2><?= $this->title ?></h2>
</div>

<div>
    <p>
        <a href="<?= Url::toRoute($createPageRoute) ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Новая роль</a>
        <?php if ($updateConstantsBtnAvailable): ?>
            <a href="<?= Url::toRoute($updateConstantsRoute) ?>" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i> Обновить список констант</a>
        <?php endif ?>
    </p>
</div>

<?php Pjax::begin() ?>

<?= $this->render('/Roles/List/GridView', [
    'rolesDataProvider' => $rolesDataProvider,
    'gridLayout' => $gridLayout,
    'gridViewColumns' => $gridViewColumns,
]); ?>

<?php Pjax::end() ?>
