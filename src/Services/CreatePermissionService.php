<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
use yii\base\Model;
use yii\rbac\ManagerInterface;

class CreatePermissionService extends Model
{
    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var string
     */
    public $permissionName;

    /**
     * @var string
     */
    public $permissionDescription;

    /**
     * @var string
     */
    public $ruleName;

    /**
     * @var IConstantsStorageService
     */
    public $constantsStorage;

    /**
     * CreatePermissionService constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['permissionName'], 'required'],
            [['permissionDescription', 'ruleName'], 'string'],
        ];
    }

    public function createPermission()
    {
        if (!$this->validate()) {
            return false;
        }

        $permission = $this->authManager->createPermission($this->permissionName);
        $permission->description = $this->permissionDescription;

        if ($this->ruleName) {
            $rule = $this->authManager->getRule($this->ruleName);
            if (empty($rule)) {
                $this->addError('ruleName', 'Указано не существующее правило');
                return false;
            }

            $permission->ruleName = $this->ruleName;
        }

        if (!$this->authManager->add($permission)) {
            $this->addError('name', 'Не удается добавить роль в систему');
            return false;
        }

        if ($this->constantsStorage) {
            $this->constantsStorage->loadCurrentData($this->authManager);
            if (!$this->constantsStorage->flush()) {
                $this->addError('roleName', 'Не удается записать RBAC константы');
                return false;
            }
        }

        return true;
    }
}