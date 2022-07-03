<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\IGetRightsManagerSettings;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use Brezgalov\ApiHelpers\v2\ILoadFromModule;
use yii\base\Model;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\rbac\ManagerInterface;

class RefreshConstantsStorageService extends Model implements ILoadFromModule
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
    }

    /**
     * @param Module $module
     */
    public function loadFromModule(Module $module)
    {
        if ($module instanceof IGetRightsManagerSettings) {
            $this->constantsStorage = $module->getConstantsStorageService();
        }
    }

    /**
     * @return bool
     */
    public function updateStorageService()
    {
        if (empty($this->constantsStorage)) {
            return true;
        }

        $this->constantsStorage->loadCurrentData($this->authManager);

        if (!$this->constantsStorage->flush()) {
            $this->addError('constantsStorage', 'Не удается обновить хранилище констант');
            return false;
        }

        return true;
    }
}