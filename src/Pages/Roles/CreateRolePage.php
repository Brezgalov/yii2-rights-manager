<?php

namespace Brezgalov\RightsManager\Pages\Roles;

use Brezgalov\RightsManager\Services\ConstantsConfigBuilderService;
use Brezgalov\RightsManager\Services\CreateRoleService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\Model;

class CreateRolePage extends Model implements IRenderFormatterDTO, IRegisterInputInterface
{
    const PAGE_PREPARE_METHOD = 'preparePageData';
    const SUBMIT_ROLE_METHOD = 'submitRole';

    /**
     * @var CreateRoleService
     */
    public $createRoleService;

    /**
     * @var bool
     */
    public $refreshConstants = false;

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
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->refreshConstants = $data['refreshConstants'] ?? $this->refreshConstants;

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
            'refreshConstants' => (bool)$this->refreshConstants,
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
    public function submitRole(ConstantsConfigBuilderService $constantsBuilder = null)
    {
        if (!$this->createRoleService->validate()) {
            $this->addErrors($this->createRoleService->getErrors());
            return $this;
        }

        if (!$this->createRoleService->createRole()) {
            $this->addErrors($this->createRoleService->getErrors());
            return $this;
        }

        if ($this->refreshConstants) {
            if (empty($constantsBuilder)) {
                $constantsBuilder = new ConstantsConfigBuilderService();
            }

            if (!$constantsBuilder->buildConfigFile()) {
                $this->createRoleService->addError('roleName', 'Не удается обновить список констант');
                return $this;
            }
        }

        return $this;
    }
}