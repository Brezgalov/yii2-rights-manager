<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;

class SubmitRightsTableService extends Model implements IRegisterInputInterface
{
    const MAIN_METHOD = 'submitTable';

    /**
     * @var array
     */
    public $table = [];

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var array
     */
    public $permissionsCache = [];

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
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->table = $data['table'] ?? $this->table;

        return true;
    }

    /**
     * @param $name
     * @return mixed|\yii\rbac\Permission
     * @throws \Exception
     */
    protected function getPermission($name)
    {
        $perm = ArrayHelper::getValue($this->permissionsCache, $name);
        if (empty($perm)) {
            $perm = $this->authManager->getPermission($name);
            $this->permissionsCache[$name] = $perm;
        }

        if (empty($perm)) {
            $this->addError('table', "Разрешение {$name} не существует");
            return false;
        }

        return $perm;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function submitTable()
    {
        $roles = $this->authManager->getRoles();
        foreach ($roles as $role) {
            $this->authManager->removeChildren($role);

            $rolePermissions = ArrayHelper::getValue($this->table, $role->name);
            if (empty($rolePermissions)) {
                continue;
            } else {
                $rolePermissions = array_keys($rolePermissions);
            }

            foreach ($rolePermissions as $permissionName) {
                $permission = $this->getPermission($permissionName);
                if (!$permission) {
                    return false;
                }

                if (!$this->authManager->addChild($role, $permission)) {
                    $this->addError('table', "Не удается сохранить привязку разрешения {$permission->name} к роли {$role->name}");
                    return false;
                }
            }
        }

        return true;
    }
}