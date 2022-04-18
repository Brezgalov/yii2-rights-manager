<?php

namespace Brezgalov\RightsManager\Pages;

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
     * @var string
     */
    public $submitFormUrl = 'roles/create-submit';

    /**
     * CreateRolePage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->createRoleService = new CreateRoleService();

        parent::__construct($config);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        return $this->createRoleService->registerInput($data);
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