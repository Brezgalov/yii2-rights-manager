<?php

namespace Brezgalov\RightsManager\Behaviors;

use Brezgalov\RightsManager\RightsManagerModule;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\rbac\ManagerInterface;

class UpdateConstantsStorageBehavior extends Behavior
{
    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var IConstantsStorageService
     */
    public $constantsStorage;

    /**
     * UpdateConstantsStorageBehavior constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager) && \Yii::$app->has('authManager')) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (!($this->authManager instanceof ManagerInterface)) {
            throw new InvalidConfigException("authManager should be set as " . ManagerInterface::class);
        }

        if (!($this->constantsStorage instanceof IConstantsStorageService)) {
            throw new InvalidConfigException("constantsStorage should be set as " . IConstantsStorageService::class);
        }
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            RightsManagerModule::EVENT_AUTH_ITEMS_LIST_UPDATED => 'updateConstantsStorage',
        ];
    }

    public function updateConstantsStorage()
    {
        $this->constantsStorage->loadCurrentData($this->authManager)->flush();
    }
}