<?php

namespace Brezgalov\RightsManager\Pages\Roles;

use Brezgalov\RightsManager\IGetRightsManagerSettings;
use Brezgalov\RightsManager\Services\CreateRoleService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\ILoadFromModule;
use Brezgalov\ApiHelpers\v2\IRegisterInput;
use yii\base\Model;
use yii\base\Module;

class CreateRolePage extends Model implements IRenderFormatterDTO, IRegisterInput, ILoadFromModule
{
    const PAGE_PREPARE_METHOD = 'preparePageData';
    const SUBMIT_ROLE_METHOD = 'submitRole';

    /**
     * @var CreateRoleService
     */
    public $createRoleService;

    /**
     * @var string
     */
    public $submitFormUrl = 'roles/create-submit';

    /**
     * CreateRolePage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->createRoleService)) {
            $this->createRoleService = new CreateRoleService();
        }
    }

    /**
     * @param Module $module
     */
    public function loadFromModule(Module $module)
    {
        if ($module instanceof IGetRightsManagerSettings) {
            $this->createRoleService->constantsStorage = $module->getConstantsStorageService();
        }
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        return $this->createRoleService->load($data);
    }

    /**
     * @return array
     */
    public function getViewParams()
    {
        return [
            'createRoleService' => $this->createRoleService,
            'submitFormUrl' => $this->submitFormUrl,
        ];
    }

    /**
     * @return $this
     */
    public function preparePageData()
    {
        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function submitRole()
    {
        if (!$this->createRoleService->validate()) {
            $this->addErrors($this->createRoleService->getErrors());
            return $this;
        }

        if (!$this->createRoleService->createRole()) {
            $this->addErrors($this->createRoleService->getErrors());
            return $this;
        }

        return $this;
    }
}