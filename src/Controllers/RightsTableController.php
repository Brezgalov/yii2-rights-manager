<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\RightsTable\GetRightsTableAction;
use Brezgalov\RightsManager\Actions\RightsTable\RightsTableSubmitAction;
use yii\web\Controller;

class RightsTableController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => GetRightsTableAction::class,
            'submit' => RightsTableSubmitAction::class,
        ];
    }
}