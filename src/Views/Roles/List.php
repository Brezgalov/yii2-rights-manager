<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ArrayDataProvider $rolesDataProvider
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
        <a href="<?= Url::toRoute($createPageRoute) ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Новая роль</a>
        <a href="<?= Url::toRoute($updateConstantsRoute) ?>" class="btn btn-default"><i class="glyphicon glyphicon-repeat"></i> Обновить список констант</a>
    </p>
</div>

<?= GridView::widget([
    'dataProvider' => $rolesDataProvider,
    'layout' => $gridLayout,
    'columns' => $gridViewColumns,
]) ?>
