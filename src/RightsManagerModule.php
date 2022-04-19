<?php

namespace Brezgalov\RightsManager;

use Brezgalov\RightsManager\Services\ConstantsStorageService\FileConstantsStorage;
use brezgalov\modules\Module;
use yii\base\InvalidConfigException;

class RightsManagerModule extends Module
{
    /**
     * @var string
     */
    public static $constantsStaticConfigPath;

    /**
     * @var string|array
     */
    public static $constantsStorageServiceConfigStatic;

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
     * class name or config
     * @var string|array
     */
    public $constantsStorageService = FileConstantsStorage::class;

    /**
     * @return string
     */
    public static function getConstantsFileConfigPath()
    {
        return static::$constantsStaticConfigPath;
    }

    /**
     * @return array|string
     */
    public static function getConstantsStorageServiceConfig()
    {
        return static::$constantsStorageServiceConfigStatic;
    }

    /**
     * init
     */
    public function init()
    {
        static::$constantsStaticConfigPath = $this->constantsConfigPath;
        static::$constantsStorageServiceConfigStatic = $this->constantsStorageService;

        if ($this->moduleLayoutPath) {
            $this->setLayoutPath($this->moduleLayoutPath);
        }

        $this->controllerNamespace = 'Brezgalov\RightsManager\Controllers';

        parent::init();
    }
}