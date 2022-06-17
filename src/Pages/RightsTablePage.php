<?php

namespace Brezgalov\RightsManager\Pages;

use Brezgalov\RightsManager\Dto\RightsTableDto;
use Brezgalov\RightsManager\Factories\RightsTableFactory;
use Brezgalov\RightsManager\Services\SubmitRightsTableService;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;

class RightsTablePage extends Model implements IRenderFormatterDTO, IRegisterInputInterface
{
    const PAGE_PREPARE_METHOD = 'preparePageData';
    const SUBMIT_TABLE_METHOD = 'submitTable';

    /**
     * @var RightsTableDto
     */
    protected $tableDto;

    /**
     * @var string
     */
    public $submitTableRoute = "rights-table/submit";

    /**
     * @var RightsTableFactory
     */
    public $rightsTableFactory;

    /**
     * @var SubmitRightsTableService
     */
    public $submitRightsService;

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * RightsTablePage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (empty($this->rightsTableFactory)) {
            $this->rightsTableFactory = new RightsTableFactory(['authManager' => $this->authManager]);
        }

        if (empty($this->submitRightsService)) {
            $this->submitRightsService = new SubmitRightsTableService(['authManager' => $this->authManager]);
        }
    }

    /**
     * @return RightsTableDto[]
     */
    public function getViewParams()
    {
        return [
            'submitRoute' => $this->submitTableRoute,
            'tableDto' => $this->tableDto,
            'tableErrors' => $this->submitRightsService->getErrorSummary(true),
        ];
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->submitRightsService->registerInput($data);

        return true;
    }

    /**
     * @return $this
     */
    public function preparePageData()
    {
        $this->tableDto = $this->rightsTableFactory->buildTableDto();

        return $this;
    }

    /**
     * @return $this
     * @throws \yii\base\Exception
     */
    public function submitTable()
    {
        if (!$this->submitRightsService->submitTable()) {
            $this->addErrors(
                $this->submitRightsService->getErrors()
            );
        }

        return $this;
    }
}