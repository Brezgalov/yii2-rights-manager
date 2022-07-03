<?php

namespace Brezgalov\RightsManager;

use Brezgalov\RightsManager\Services\ConstantsStorageService\FileConstantsStorage;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use Brezgalov\RightsManager\Views\ViewContext;
use brezgalov\modules\Module;
use yii\base\InvalidConfigException;
use yii\base\ViewContextInterface;

class RightsManagerModule extends Module implements IGetRightsManagerSettings
{
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
     * @var bool
     */
    public $useConstantsStorage = true;

    /**
     * class name or config
     * @var string|array
     */
    public $constantsStorageServiceSetup;

    /**
     * @var IConstantsStorageService
     */
    public $constantsStorageService;

    /**
     * setup for ViewContextInterface
     * @var string|array
     */
    public $viewContext = ViewContext::class;

    /**
     * init
     */
    public function init()
    {
        /** @var ViewContextInterface $viewContext */
        $viewContext = \Yii::createObject($this->viewContext);
        $this->viewPath = $viewContext->getViewPath();

        if ($this->moduleLayoutPath) {
            $this->setLayoutPath($this->moduleLayoutPath);
        }

        $this->controllerNamespace = 'Brezgalov\RightsManager\Controllers';

        parent::init();
    }

    /**
     * @return IConstantsStorageService|null
     */
    public function getConstantsStorageService()
    {
        if (!$this->useConstantsStorage) {
            return null;
        }

        if (empty($this->constantsStorageService)) {
            $this->constantsStorageService = \Yii::createObject($this->constantsStorageServiceSetup);

            if (!($this->constantsStorageService instanceof IConstantsStorageService)) {
                throw new InvalidConfigException('$constantsStorageService should be instance of ' . IConstantsStorageService::class);
            }
        }

        return $this->constantsStorageService;
    }

    /**
     * @return bool
     */
    public function useConstantsStorageService()
    {
        return $this->useConstantsStorage;
    }
}