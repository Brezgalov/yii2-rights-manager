<?php

namespace Brezgalov\RightsManager\Actions\Permissions;

use Brezgalov\RightsManager\Pages\Permissions\CreatePermissionPage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\RenderAction;

class CreatePermissionAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = CreatePermissionPage::class;

    /**
     * @var string
     */
    public $methodName = CreatePermissionPage::PAGE_PREPARE_METHOD;

    /**
     * @var string
     */
    public $title = 'Добавить новое разрешение';

    /**
     * @var string
     */
    public $view = 'Permissions/Create';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;

    /**
     * @return array
     */
    protected function getDefaultBehaviors()
    {
        return [
            LoadServiceFromModuleBehavior::class
        ];
    }
}