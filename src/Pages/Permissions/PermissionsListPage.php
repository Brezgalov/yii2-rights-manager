<?php

namespace Brezgalov\RightsManager\Pages\Permissions;

use Brezgalov\RightsManager\IGetRightsManagerSettings;
use Brezgalov\ApiHelpers\v2\DTO\IRenderFormatterDTO;
use Brezgalov\ApiHelpers\v2\ILoadFromModule;
use kartik\grid\ActionColumn;
use kartik\grid\EditableColumn;
use yii\base\Model;
use yii\base\Module;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission;

class PermissionsListPage extends Model implements IRenderFormatterDTO, ILoadFromModule
{
    const PAGE_PREPARE_METHOD = 'preparePageData';

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var ArrayDataProvider
     */
    public $permissionsDataProvider;

    /**
     * @var string
     */
    public $gridLayout = '{items}';

    /**
     * @var string
     */
    public $createPageRoute = 'permissions/create';

    /**
     * @var string
     */
    public $updatePageRoute = 'permissions/update';

    /**
     * @var string
     */
    public $updateConstantsRoute = 'constants/update-storage/';

    /**
     * @var array
     */
    public $gridViewColumns;

    /**
     * @var bool
     */
    public $updateConstantsBtnAvailable = true;

    /**
     * PermissionsListPage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (empty($this->permissionsDataProvider)) {
            $this->permissionsDataProvider = new ArrayDataProvider(['pagination' => false]);
        }
    }

    /**
     * @param Module $module
     */
    public function loadFromModule(Module $module)
    {
        if ($module instanceof IGetRightsManagerSettings) {
            $this->updateConstantsBtnAvailable = $module->useConstantsStorageService();
        }
    }

    /**
     * @return ArrayDataProvider[]
     */
    public function getViewParams()
    {
        return [
            'permissionsDataProvider' => $this->permissionsDataProvider,
            'gridViewColumns' => $this->getColumns(),
            'gridLayout' => $this->gridLayout,
            'createPageRoute' => $this->createPageRoute,
            'updateConstantsRoute' => $this->updateConstantsRoute,
            'updateConstantsBtnAvailable' => $this->updateConstantsBtnAvailable,
        ];
    }

    /**
     * @return $this
     */
    public function preparePageData()
    {
        $this->permissionsDataProvider->models = $this->authManager->getPermissions();

        return $this;
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
                'value' => function(Permission $permission) {
                    return $permission->description ?: '';
                },
                'editableOptions' => [
                    'name' => 'description',
                    'formOptions' => ['action' => [Url::toRoute($this->updatePageRoute)]],
                ],
            ],
            [
                'attribute' => 'createdAt',
                'label' => 'Дата создания',
                'value' => function(Permission $permission) {
                    return $permission->createdAt ? date('d.m.Y H:i:s', $permission->createdAt) : null;
                }
            ],
            [
                'attribute' => 'updatedAt',
                'label' => 'Дата редактирования',
                'value' => function(Permission $permission) {
                    return $permission->updatedAt ? date('d.m.Y H:i:s', $permission->updatedAt) : null;
                }
            ],
            [
                'class' => ActionColumn::class,
                'header' => '',
                'template' => '{delete}',
                'deleteOptions' => [
                    'data-pjax' => '1',
                ],
            ],
        ];
    }
}