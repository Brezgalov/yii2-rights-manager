<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\RightsManagerModule;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\rbac\ManagerInterface;

class RefreshConstantsStorageService extends Model
{
    const MAIN_METHOD = 'updateStorageService';

    /**
     * @var IConstantsStorageService
     */
    public $constantsStorage;

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * RefreshConstantsStorageService constructor.
     * @param array $config
     * @throws InvalidConfigException
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (empty($this->constantsStorage)) {
            $constServiceConfig = RightsManagerModule::getConstantsStorageServiceConfig();
            if (empty($constServiceConfig)) {
                throw new InvalidConfigException('constantsStorageService should be set');
            }

            $this->constantsStorage = \Yii::createObject($constServiceConfig);
        }
    }

    /**
     * @return bool
     */
    public function updateStorageService()
    {
        $this->constantsStorage->loadCurrentData($this->authManager);

        if (!$this->constantsStorage->flush()) {
            $this->addError('constantsStorage', 'Не удается обновить хранилище констант');
            return false;
        }

        return true;
    }
}