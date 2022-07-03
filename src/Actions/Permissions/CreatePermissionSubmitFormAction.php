<?php

namespace Brezgalov\RightsManager\Actions\Permissions;

use Brezgalov\RightsManager\Pages\Permissions\CreatePermissionPage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\DelayedEventsBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\MutexBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\TransactionBehavior;
use Brezgalov\ApiHelpers\v2\SubmitRenderAction;

class CreatePermissionSubmitFormAction extends SubmitRenderAction
{
    /**
     * @var string
     */
    public $service = CreatePermissionPage::class;

    /**
     * @var string
     */
    public $methodName = CreatePermissionPage::SUBMIT_PERMISSION_METHOD;

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
    public $successRedirectRoute = 'permissions/';

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