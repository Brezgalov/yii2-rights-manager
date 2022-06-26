<?php

use Brezgalov\RightsManager\Views\ViewContext;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var View $this
 * @var ArrayDataProvider $permissionsDataProvider
 * @var string $gridViewColumns
 * @var string $gridLayout
 * @var string $createPageRoute
 * @var string $updateConstantsRoute
 */

?>
<div>
    <h2><?= $this->title ?></h2>
</div>

<div>
    <p>
        <a href="<?= Url::toRoute($createPageRoute) ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Новое разрешение</a>
        <a href="<?= Url::toRoute($updateConstantsRoute) ?>" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i> Обновить список констант</a>
    </p>
</div>

<?php Pjax::begin() ?>

<?= $this->render('/Permissions/List/GridView', [
    'permissionsDataProvider' => $permissionsDataProvider,
    'gridLayout' => $gridLayout,
    'gridViewColumns' => $gridViewColumns,
]) ?>

<?php Pjax::end() ?>
