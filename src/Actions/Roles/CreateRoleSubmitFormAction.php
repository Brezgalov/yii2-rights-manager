<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Pages\Roles\CreateRolePage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\TransactionBehavior;
use Brezgalov\ApiHelpers\v2\SubmitRenderAction;

class CreateRoleSubmitFormAction extends SubmitRenderAction
{
    /**
     * @var string
     */
    public $service = CreateRolePage::class;

    /**
     * @var string
     */
    public $methodName = CreateRolePage::SUBMIT_ROLE_METHOD;

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
    public $successRedirectRoute = 'roles/';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;
}