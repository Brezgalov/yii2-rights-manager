<?php

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ArrayDataProvider $permissionsDataProvider
 * @var string $gridViewColumns
 * @var string $gridLayout
 */

echo GridView::widget([
    'dataProvider' => $permissionsDataProvider,
    'layout' => $gridLayout,
    'columns' => $gridViewColumns,
]);