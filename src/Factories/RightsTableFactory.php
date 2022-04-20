<?php

namespace Brezgalov\RightsManager\Factories;

use Brezgalov\RightsManager\Dto\RightsTableDto;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission;
use yii\rbac\Role;

class RightsTableFactory extends Component
{
    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * RightsTableFactory constructor.
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
     * @return RightsTableDto
     */
    public function buildTableDto()
    {
        if (empty($this->authManager)) {
            throw new InvalidConfigException('authManager is required');
        }

        $roles = $this->authManager->getRoles();
        usort($roles, function ($a, $b) {
            /** @var Role $a */
            /** @var Role $b */
            return strcmp($a->name, $b->name);
        });
        $roles = ArrayHelper::index($roles, 'name');

        $permissions = $this->authManager->getPermissions();
        usort($permissions, function ($a, $b) {
            /** @var Permission $a */
            /** @var Permission $b */
            return strcmp($a->name, $b->name);
        });
        $permissions = ArrayHelper::index($permissions, 'name');

        $table = [];
        foreach ($roles as $role) {
            $table[$role->name] = [];

            foreach ($permissions as $permission) {
                $table[$role->name][$permission->name] = 0;
            }

            $permissionsActive = $this->authManager->getPermissionsByRole($role->name);
            foreach ($permissionsActive as $activePermission) {
                $table[$role->name][$activePermission->name] = 1;
            }
        }

        return new RightsTableDto([
            'table' => $table,
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }
}