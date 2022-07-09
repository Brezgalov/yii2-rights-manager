<?php

use Brezgalov\RightsManager\Behaviors\UpdateConstantsStorageBehavior;
use Brezgalov\RightsManager\RightsManagerModule;
use PHPUnit\Framework\TestCase;
use yii\base\Application;

/**
 * Class RightsManagerModuleTest
 *
 * @coversDefaultClass \Brezgalov\RightsManager\RightsManagerModule
 */
class RightsManagerModuleTest extends TestCase
{
    /**
     * @return Application
     */
    protected function getApp()
    {
        $app = \Yii::$app;

        $this->assertInstanceOf(Application::class, $app);

        return $app;
    }

    /**
     * @param Application $app
     * @return RightsManagerModule
     * @throws \yii\base\InvalidConfigException
     */
    protected function getModule(Application $app)
    {
        $this->assertTrue($app->has(RIGHTS_MANAGER_COMP_NAME));

        $module = $app->get(RIGHTS_MANAGER_COMP_NAME);
        $this->assertInstanceOf(RightsManagerModule::class, $module);

        return $module;
    }

    /**
     * @covers ::useConstantsStorageService
     * @covers ::enableConstantsStorage
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function testConstantsStorageEnabled()
    {
        $app = $this->getApp();
        $module = $this->getModule($app);

        $module->enableConstantsStorage($app);

        $this->assertTrue($module->useConstantsStorageService());
        $this->assertTrue(
            $app->hasEventHandlers(RightsManagerModule::EVENT_AUTH_ITEMS_LIST_UPDATED)
        );

        $behavior = $app->getBehavior(
            $module->getBehaviorName(RightsManagerModule::UPDATE_CONSTANTS_BEHAVIOR_NAME)
        );

        $this->assertInstanceOf(UpdateConstantsStorageBehavior::class, $behavior);
    }

    /**
     * @covers ::useConstantsStorageService
     * @covers ::disableConstantsStorage
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function testConstantsStorageDisabled()
    {
        $app = $this->getApp();
        $module = $this->getModule($app);

        $module->disableConstantsStorage($app);

        $this->assertFalse($module->useConstantsStorageService());
        $this->assertFalse(
            $app->hasEventHandlers(RightsManagerModule::EVENT_AUTH_ITEMS_LIST_UPDATED)
        );

        $this->assertEmpty(
            $app->getBehavior(
                $module->getBehaviorName(
                    RightsManagerModule::UPDATE_CONSTANTS_BEHAVIOR_NAME
                )
            )
        );
    }
}