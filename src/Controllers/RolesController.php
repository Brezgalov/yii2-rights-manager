<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\Roles\CreateRolePageAction;
use Brezgalov\RightsManager\Actions\Roles\CreateRoleSubmitFormAction;
use Brezgalov\RightsManager\Actions\Roles\RolesListPageAction;
use Brezgalov\RightsManager\Actions\Roles\UpdateRoleAttributeAction;
use yii\web\Controller;

class RolesController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        return [
            'index' => RolesListPageAction::class,
            'create' => CreateRolePageAction::class,
            'create-submit' => CreateRoleSubmitFormAction::class,
            'update' => UpdateRoleAttributeAction::class,
        ];
    }
}