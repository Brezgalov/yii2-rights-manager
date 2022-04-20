<?php

namespace Brezgalov\RightsManager\Pages\Roles;

use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use yii\base\Component;
use yii\data\ArrayDataProvider;
use yii\rbac\ManagerInterface;

class RolesListPage extends Component implements IRenderFormatterDTO
{
    const PAGE_PREPARE_METHOD = 'preparePageData';

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var ArrayDataProvider
     */
    public $rolesDataProvider;

    /**
     * RolesListPage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->authManager = \Yii::$app->authManager;
        $this->rolesDataProvider = new ArrayDataProvider(['pagination' => false]);

        parent::__construct($config);
    }

    /**
     * @return $this
     */
    public function preparePageData()
    {
        $this->rolesDataProvider->models = $this->authManager->getRoles();

        return $this;
    }

    /**
     * @return array
     */
    public function getViewParams()
    {
        return ['rolesDataProvider' => $this->rolesDataProvider];
    }
}