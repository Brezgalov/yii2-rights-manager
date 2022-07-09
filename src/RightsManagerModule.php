<?php

namespace Brezgalov\RightsManager;

use Brezgalov\RightsManager\Behaviors\UpdateConstantsStorageBehavior;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use Brezgalov\RightsManager\Views\ViewContext;
use brezgalov\modules\Module;
use yii\base\Application;
use yii\base\InvalidConfigException;
use yii\base\ViewContextInterface;

class RightsManagerModule extends Module implements IGetRightsManagerSettings
{
    const EVENT_AUTH_ITEMS_LIST_UPDATED = 'authItemsListUpdated';

    const UPDATE_CONSTANTS_BEHAVIOR_NAME = 'updateConstantsBehavior';

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
     * @var string
     */
    public $controllerNamespace = 'Brezgalov\RightsManager\Controllers';

    /**
     * Set to false to disable prefixes
     * @var bool|string|null
     */
    public $behaviorsPrefix;

    /**
     * init
     */
    public function init()
    {
        /** @var ViewContextInterface $viewContext */
        $viewContext = \Yii::createObject($this->viewContext);
        $this->viewPath = $viewContext->getViewPath();

        if (is_null($this->behaviorsPrefix)) {
            $this->behaviorsPrefix = $this->id ? "{$this->id}/" : "";
        }

        if ($this->moduleLayoutPath) {
            $this->setLayoutPath($this->moduleLayoutPath);
        }

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

        if ($this->useConstantsStorage) {

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

    /**
     * @param Application|null $app
     */
    public function enableConstantsStorage(Application $app = null)
    {
        if (empty($app)) {
            $app = \Yii::$app;
        }

        $this->useConstantsStorage = true;

        $app->attachBehavior($this->getBehaviorName(static::UPDATE_CONSTANTS_BEHAVIOR_NAME), [
            'class' => UpdateConstantsStorageBehavior::class,
            'constantsStorage' => $this->getConstantsStorageService(),
        ]);
    }

    /**
     * @param Application|null $app
     */
    public function disableConstantsStorage(Application $app = null)
    {
        if (empty($app)) {
            $app = \Yii::$app;
        }

        $this->useConstantsStorage = false;
        $app->detachBehavior(
            $this->getBehaviorName(static::UPDATE_CONSTANTS_BEHAVIOR_NAME)
        );
    }

    /**
     * @return string
     */
    public function getBehaviorName($name)
    {
        return "{$this->behaviorsPrefix}{$name}";
    }
}