<?php

namespace Brezgalov\RightsManager;

use Brezgalov\RightsManager\Services\ConstantsStorageService\FileConstantsStorage;
use Brezgalov\RightsManager\Views\ViewContext;
use brezgalov\modules\Module;
use yii\base\InvalidConfigException;
use yii\base\ViewContextInterface;

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
     * setup for ViewContextInterface
     * @var string|array
     */
    public $viewContext = ViewContext::class;

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
        /** @var ViewContextInterface $viewContext */
        $viewContext = \Yii::createObject($this->viewContext);
        $this->viewPath = $viewContext->getViewPath();

        static::$constantsStaticConfigPath = $this->constantsConfigPath;
        static::$constantsStorageServiceConfigStatic = $this->constantsStorageService;

        if ($this->moduleLayoutPath) {
            $this->setLayoutPath($this->moduleLayoutPath);
        }

        $this->controllerNamespace = 'Brezgalov\RightsManager\Controllers';

        parent::init();
    }
}