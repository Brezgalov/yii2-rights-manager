<?php

namespace Brezgalov\RightsManager;

use brezgalov\modules\Module;
use yii\base\InvalidConfigException;

class RightsManagerModule extends Module
{
    /**
     * @var string
     */
    public static $constantsStaticConfigPath;

    /**
     * @var string
     */
    public $webControllersFolder = 'Controllers';

    /**
     * @var string
     */
    public $moduleLayoutPath = __DIR__ . '/Views/Layout';

    /**
     * @var string
     */
    public $layout = 'Main';

    /**
     * @var string
     */
    public $constantsConfigPath;

    /**
     * init
     */
    public function init()
    {
        if (empty($this->constantsConfigPath)) {
            throw new InvalidConfigException('constantsConfigPath should be set');
        }

        static::$constantsStaticConfigPath = $this->constantsConfigPath;

        if ($this->moduleLayoutPath) {
            $this->setLayoutPath($this->moduleLayoutPath);
        }

        $this->controllerNamespace = 'Brezgalov\RightsManager\Controllers';

        parent::init();
    }
}