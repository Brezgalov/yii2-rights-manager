<?php

namespace Brezgalov\RightsManager\Actions\Permissions;

use Brezgalov\RightsManager\Services\UpdateAuthItemAttributeService;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\DelayedEventsBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\MutexBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\TransactionBehavior;
use Brezgalov\ApiHelpers\v2\Formatters\RestFormatter;

class UpdatePermissionAttributeAction extends ApiPostAction
{
    /**
     * @var string
     */
    public $methodName = UpdateAuthItemAttributeService::MAIN_METHOD;

    /**
     * @var string
     */
    public $formatter = RestFormatter::class;

    /**
     * UpdatePermissionAttributeAction constructor.
     * @param $id
     * @param $controller
     * @param array $config
     */
    public function __construct($id, $controller, $config = [])
    {
        $this->service = [
            'class' => UpdateAuthItemAttributeService::class,
            'mode' => UpdateAuthItemAttributeService::getPermissionMode(),
        ];

        parent::__construct($id, $controller, $config);
    }

    /**
     * @return string[]
     */
    protected function getDefaultBehaviors()
    {
        return [
            ApiPostAction::BEHAVIOR_KEY_TRANSACTION => TransactionBehavior::class,
            ApiPostAction::BEHAVIOR_KEY_MUTEX  => MutexBehavior::class,
            ApiPostAction::BEHAVIOR_KEY_DELAYED_EVENTS  => DelayedEventsBehavior::class,
            LoadServiceFromModuleBehavior::class,
        ];
    }
}