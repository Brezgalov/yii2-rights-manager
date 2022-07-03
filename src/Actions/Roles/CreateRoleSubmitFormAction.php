<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Pages\Roles\CreateRolePage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\DelayedEventsBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\MutexBehavior;
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

    /**
     * @return array
     */
    protected function getDefaultBehaviors()
    {
        return [
            SubmitRenderAction::BEHAVIOR_KEY_TRANSACTION => TransactionBehavior::class,
            SubmitRenderAction::BEHAVIOR_KEY_MUTEX => MutexBehavior::class,
            SubmitRenderAction::BEHAVIOR_KEY_DELAYED_EVENTS => DelayedEventsBehavior::class,
            LoadServiceFromModuleBehavior::class,
        ];
    }
}