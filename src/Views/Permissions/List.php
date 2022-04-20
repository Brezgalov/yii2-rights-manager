<?php

use kartik\grid\GridView;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ArrayDataProvider $permissionsDataProvider
 * @var string $gridViewColumns
 * @var string $gridLayout
 * @var string $createPageRoute
 */

?>
<div>
    <h2><?= $this->title ?></h2>
</div>

<div>
    <p>
        <a href="<?= Url::toRoute($createPageRoute) ?>" class="btn btn-success"><i class="glyphicon glyphicon-plus"></i> Новое разрешение</a>
    </p>
</div>

<?= GridView::widget([
    'dataProvider' => $permissionsDataProvider,
    'layout' => $gridLayout,
    'columns' => $gridViewColumns,
]) ?>
