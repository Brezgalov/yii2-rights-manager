<?php

namespace Brezgalov\RightsManager\Actions\Constants;

use Brezgalov\RightsManager\Services\RefreshConstantsStorageService;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\DelayedEventsBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\MutexBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\TransactionBehavior;
use Brezgalov\ApiHelpers\v2\Formatters\RedirectBackFormatter;

class UpdateStorageAction extends ApiPostAction
{
    /**
     * @var string
     */
    public $service = RefreshConstantsStorageService::class;

    /**
     * @var string
     */
    public $methodName = RefreshConstantsStorageService::MAIN_METHOD;

    /**
     * @var string
     */
    public $formatter = RedirectBackFormatter::class;

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