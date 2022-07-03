<?php

namespace Brezgalov\RightsManager\Actions\Permissions;

use Brezgalov\RightsManager\Pages\Permissions\PermissionsListPage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\RenderAction;

class PermissionsListPageAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = PermissionsListPage::class;

    /**
     * @var string
     */
    public $methodName = PermissionsListPage::PAGE_PREPARE_METHOD;

    /**
     * @var string
     */
    public $title = 'Разрешения';

    /**
     * @var string
     */
    public $view = 'Permissions/List';

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