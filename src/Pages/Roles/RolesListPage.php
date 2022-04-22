<?php

namespace Brezgalov\RightsManager\Pages\Roles;

use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use kartik\grid\ActionColumn;
use kartik\grid\EditableColumn;
use yii\base\Component;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\rbac\ManagerInterface;
use yii\rbac\Role;

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
     * @var array
     */
    public $gridViewColumns;

    /**
     * @var string
     */
    public $gridLayout = '{items}';

    /**
     * @var string
     */
    public $createPageRoute = 'roles/create';

    /**
     * @var string
     */
    public $updatePageRoute = 'roles/update';

    /**
     * @var string
     */
    public $updateConstantsRoute = 'constants/update-storage/';

    /**
     * RolesListPage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (empty($this->rolesDataProvider)) {
            $this->rolesDataProvider = new ArrayDataProvider(['pagination' => false]);
        }
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
        return [
            'rolesDataProvider' => $this->rolesDataProvider,
            'gridViewColumns' => $this->getColumns(),
            'gridLayout' => $this->gridLayout,
            'createPageRoute' => $this->createPageRoute,
            'updateConstantsRoute' => $this->updateConstantsRoute,
        ];
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        if ($this->gridViewColumns) {
            return $this->gridViewColumns;
        }

        return [
            [
                'class' => EditableColumn::class,
                'attribute' => 'name',
                'label' => 'Название',
                'editableOptions' => [
                    'name' => 'name',
                    'formOptions' => ['action' => [Url::toRoute($this->updatePageRoute)]],
                ],
            ],
            [
                'class' => EditableColumn::class,
                'attribute' => 'description',
                'label' => 'Описание',
                'value' => function(Role $role) {
                    return $role->description ?: '';
                },
                'editableOptions' => [
                    'name' => 'description',
                    'formOptions' => ['action' => [Url::toRoute($this->updatePageRoute)]],
                ],
            ],
            [
                'attribute' => 'createdAt',
                'label' => 'Дата создания',
                'value' => function(Role $role) {
                    return $role->createdAt ? date('d.m.Y H:i:s', $role->createdAt) : null;
                }
            ],
            [
                'attribute' => 'updatedAt',
                'label' => 'Дата редактирования',
                'value' => function(Role $role) {
                    return $role->updatedAt ? date('d.m.Y H:i:s', $role->updatedAt) : null;
                }
            ],
            [
                'class' => ActionColumn::class,
                'header' => '',
                'template' => '{delete}',
            ],
        ];
    }
}