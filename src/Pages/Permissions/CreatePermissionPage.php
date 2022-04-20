<?php

namespace Brezgalov\RightsManager\Pages\Permissions;

use Brezgalov\RightsManager\Services\ConstantsConfigBuilderService;
use Brezgalov\RightsManager\Services\CreatePermissionService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\Model;
use yii\rbac\ManagerInterface;

class CreatePermissionPage extends Model implements IRegisterInputInterface, IRenderFormatterDTO
{
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
     * @var array
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
        // @todo: подготовить данные

        return $this;
    }

    /**
     * @param ConstantsConfigBuilderService|null $constantsBuilder
     * @return $this
     */
    public function submitPermission(ConstantsConfigBuilderService $constantsBuilder = null)
    {
        // @todo: записать разрешение
    }
}