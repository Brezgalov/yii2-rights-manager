<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\Roles\CreateRolePageAction;
use Brezgalov\RightsManager\Actions\Roles\CreateRoleSubmitFormAction;
use Brezgalov\RightsManager\Actions\Roles\RolesListPageAction;
use yii\web\Controller;

class RolesController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'list' => RolesListPageAction::class,
            'create' => CreateRolePageAction::class,
            'create-submit' => CreateRoleSubmitFormAction::class,
        ];
    }
}