<?php

namespace Brezgalov\RightsManager\Pages;

use Brezgalov\RightsManager\Dto\RightsTableDto;
use Brezgalov\RightsManager\Factories\RightsTableFactory;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use yii\base\Model;
use yii\rbac\ManagerInterface;

class RightsTablePage extends Model implements IRenderFormatterDTO
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
     * @return RightsTableDto[]
     */
    public function getViewParams()
    {
        return [
            'submitRoute' => $this->submitTableRoute,
            'tableDto' => $this->tableDto,
        ];
    }
}