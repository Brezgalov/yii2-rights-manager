<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Pages\Roles\RolesListPage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\RenderAction;

class RolesListPageAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = RolesListPage::class;

    /**
     * @var string
     */
    public $methodName = RolesListPage::PAGE_PREPARE_METHOD;

    /**
     * @var string
     */
    public $title = 'Роли';

    /**
     * @var string
     */
    public $view = 'Roles/List';

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