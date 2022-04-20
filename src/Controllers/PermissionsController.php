<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\Permissions\PermissionsListPageAction;
use yii\web\Controller;

class PermissionsController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => PermissionsListPageAction::class,
        ];
    }
}