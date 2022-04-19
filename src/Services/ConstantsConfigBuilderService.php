<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\RightsManagerModule;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\rbac\ManagerInterface;

class ConstantsConfigBuilderService extends Component
{
    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var string
     */
    public $configFilePath;

    /**
     * @var IConstantsStorageService
     */
    public $constantsStorage;

    /**
     * ConstantsConfigBuilderService constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->authManager = \Yii::$app->authManager;

        parent::__construct($config);

        if (empty($this->constantsStorage)) {
            $this->constantsStorage = RightsManagerModule::getConstantsStorageServiceConfig();
        }

        if (empty($this->constantsStorage)) {
            throw new InvalidConfigException('constantsStorage should be set');
        }
    }

    /**
     * @return IConstantsStorageService
     * @throws InvalidConfigException
     */
    public function getConstantsStorage()
    {
        if ($this->constantsStorage instanceof IConstantsStorageService) {
            return $this->constantsStorage;
        }

        return \Yii::createObject($this->constantsStorage);
    }

    /**
     * @return bool
     * @throws InvalidConfigException
     */
    public function buildConfigFile()
    {
        $roles = $this->authManager->getRoles();

        return true;
    }
}