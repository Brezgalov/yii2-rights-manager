<?php

namespace Brezgalov\RightsManager\Pages\Permissions;

use Brezgalov\RightsManager\Services\ConstantsConfigBuilderService;
use Brezgalov\RightsManager\Services\CreatePermissionService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\Model;
use yii\db\Exception;
use yii\rbac\ManagerInterface;
use yii\rbac\Rule;

class CreatePermissionPage extends Model implements IRegisterInputInterface, IRenderFormatterDTO
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
     * @var bool
     */
    public $refreshConstants = false;

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
        $this->refreshConstants = $data['refreshConstants'] ?? $this->refreshConstants;

        $this->createPermissionService->load($data);

        return true;
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
            'refreshConstants' => (bool)$this->refreshConstants,
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
     * @param ConstantsConfigBuilderService|null $constantsBuilder
     * @return $this
     */
    public function submitPermission(ConstantsConfigBuilderService $constantsBuilder = null)
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

        if ($this->refreshConstants) {
            if (empty($constantsBuilder)) {
                $constantsBuilder = new ConstantsConfigBuilderService();
            }

            if (!$constantsBuilder->buildConfigFile()) {
                $this->createPermissionService->addError('permissionName', 'Не удается обновить список констант');
                return $this;
            }
        }

        return $this;
    }
}