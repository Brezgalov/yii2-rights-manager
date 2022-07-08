<?php

namespace Brezgalov\RightsManager;

use Brezgalov\RightsManager\Behaviors\UpdateConstantsStorageBehavior;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use Brezgalov\RightsManager\Views\ViewContext;
use brezgalov\modules\Module;
use yii\base\InvalidConfigException;
use yii\base\ViewContextInterface;

class RightsManagerModule extends Module implements IGetRightsManagerSettings
{
    const EVENT_AUTH_ITEMS_LIST_UPDATED = 'authItemsListUpdated';

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
    protected $innerConstantsStorageService;

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

        if ($this->useConstantsStorage && empty($this->constantsStorageServiceSetup)) {
            throw new InvalidConfigException("constantsStorageServiceSetup should be set");
        }

        if ($this->constantsStorageServiceSetup) {
            $this->innerConstantsStorageService = \Yii::createObject($this->constantsStorageServiceSetup);
        }

        parent::init();
    }

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        parent::bootstrap($app);

        $behaviorsPrefix = $this->id ? "{$this->id}/" : "";

        if ($this->useConstantsStorage) {
            \Yii::$app->attachBehavior("{$behaviorsPrefix}updateConstantsBehavior", [
                'class' => UpdateConstantsStorageBehavior::class,
                'constantsStorage' => $this->getConstantsStorageService(),
            ]);
        }
    }

    /**
     * @return bool
     */
    public function useConstantsStorageService()
    {
        return $this->useConstantsStorage;
    }

    /**
     * @return IConstantsStorageService
     */
    public function getConstantsStorageService()
    {
        return $this->innerConstantsStorageService;
    }
}