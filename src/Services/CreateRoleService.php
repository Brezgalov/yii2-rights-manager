<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\RightsManagerModule;
use yii\base\Model;
use yii\rbac\ManagerInterface;

class CreateRoleService extends Model
{
    /**
     * @var string
     */
    public $roleName;

    /**
     * @var string
     */
    public $roleDescription;

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * CreateRoleService constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
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
            [['roleName'], 'required'],
            [['roleDescription'], 'string'],
        ];
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function createRole()
    {
        if (!$this->validate()) {
            return false;
        }

        $role = $this->authManager->createRole(
            mb_strtolower($this->roleName)
        );

        $role->description = $this->roleDescription;

        if (!$this->authManager->add($role)) {
            $this->addError('roleName', 'Не удается добавить роль в систему');
            return false;
        }

        \Yii::$app->trigger(RightsManagerModule::EVENT_AUTH_ITEMS_LIST_UPDATED);

        return true;
    }
}