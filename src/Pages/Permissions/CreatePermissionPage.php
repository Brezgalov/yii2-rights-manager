<?php

namespace Brezgalov\RightsManager\Pages\Permissions;

use Brezgalov\RightsManager\IGetRightsManagerSettings;
use Brezgalov\RightsManager\Services\CreatePermissionService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\ILoadFromModule;
use Brezgalov\ApiHelpers\v2\IRegisterInput;
use yii\base\Model;
use yii\base\Module;
use yii\rbac\ManagerInterface;

class CreatePermissionPage extends Model implements IRegisterInput, IRenderFormatterDTO, ILoadFromModule
{
    const PAGE_PREPARE_METHOD = 'preparePageData';
    const SUBMIT_PERMISSION_METHOD = 'submitPermission';

    /**
     * @var string
     */
    public $submitFormUrl = 'permissions/create-submit';

    /**
     * @var CreatePermissionService
     */
    public $createPermissionService;

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var string[]
     */
    protected $rulesList = [];

    /**
     * CreatePermissionPage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (empty($this->createPermissionService)) {
            $this->createPermissionService = new CreatePermissionService(['authManager' => $this->authManager]);
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->createPermissionService->load($data);

        return true;
    }

    public function loadFromModule(Module $module)
    {
        if ($module instanceof IGetRightsManagerSettings) {
            $this->createPermissionService->constantsStorage = $module->getConstantsStorageService();
        }
    }

    /**
     * @return array
     */
    public function getViewParams()
    {
        return [
            'createPermissionService' => $this->createPermissionService,
            'rulesList' => $this->rulesList,
            'submitFormUrl' => $this->submitFormUrl,
        ];
    }

    /**
     * @return $this
     */
    public function preparePageData()
    {
        foreach ($this->authManager->getRules() as $rule) {
            $this->rulesList[$rule->name] = $rule->name;
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function submitPermission()
    {
        $this->preparePageData();

        if (!$this->createPermissionService->validate()) {
            $this->addErrors($this->createPermissionService->getErrors());
            return $this;
        }

        if (!$this->createPermissionService->createPermission()) {
            $this->addErrors($this->createPermissionService->getErrors());
            return $this;
        }

        return $this;
    }
}