<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Pages\Roles\CreateRolePage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\RenderAction;

class CreateRolePageAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = CreateRolePage::class;

    /**
     * @var string
     */
    public $methodName = CreateRolePage::PAGE_PREPARE_METHOD;

    /**
     * @var string
     */
    public $title = 'Добавить новую роль';

    /**
     * @var string
     */
    public $view = 'Roles/Create';

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