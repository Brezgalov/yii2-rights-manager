<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\Permissions\CreatePermissionAction;
use Brezgalov\RightsManager\Actions\Permissions\CreatePermissionSubmitFormAction;
use Brezgalov\RightsManager\Actions\Permissions\PermissionsListPageAction;
use Brezgalov\RightsManager\Actions\Permissions\RemoveRolePjaxAction;
use Brezgalov\RightsManager\Actions\Permissions\UpdatePermissionAttributeAction;
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
            'create' => CreatePermissionAction::class,
            'create-submit' => CreatePermissionSubmitFormAction::class,
            'update' => UpdatePermissionAttributeAction::class,
            'delete' => RemoveRolePjaxAction::class,
        ];
    }
}