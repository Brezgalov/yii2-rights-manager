<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\RightsTable\IndexAction;
use yii\web\Controller;

class RightsTableController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => IndexAction::class,
        ];
    }
}