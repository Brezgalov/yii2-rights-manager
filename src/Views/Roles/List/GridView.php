<?php

use kartik\grid\GridView;
use yii\data\ArrayDataProvider;
use yii\web\View;

/**
 * @var View $this
 * @var ArrayDataProvider $rolesDataProvider
 * @var string $gridViewColumns
 * @var string $gridLayout
 */

echo GridView::widget([
    'dataProvider' => $rolesDataProvider,
    'layout' => $gridLayout,
    'columns' => $gridViewColumns,
]);