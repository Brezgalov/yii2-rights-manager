<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\RightsManagerModule;
use yii\base\Component;
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
     * @var string
     */
    public $rightsManagerModuleClass = RightsManagerModule::class;

    /**
     * ConstantsConfigBuilderService constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->authManager = \Yii::$app->authManager;

        parent::__construct($config);
    }

    public function buildConfigFile()
    {
        $moduleClass = $this->rightsManagerModuleClass;

        $configPath = $this->configFilePath ?: $moduleClass::$constantsStaticConfigPath;

        $a = 1;
    }
}