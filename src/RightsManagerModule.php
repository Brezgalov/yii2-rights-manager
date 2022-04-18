<?php

namespace Brezgalov\RightsManager;

use brezgalov\modules\Module;

class RightsManagerModule extends Module
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
     * init
     */
    public function init()
    {
        if ($this->moduleLayoutPath) {
            $this->setLayoutPath($this->moduleLayoutPath);
        }

        $this->controllerNamespace = 'Brezgalov\RightsManager\Controllers';

        parent::init();
    }
}