<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\Model;
use yii\rbac\ManagerInterface;

class CreateRoleService extends Model implements IRegisterInputInterface
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
     */
    public function __construct($config = [])
    {
        $this->authManager = \Yii::$app->authManager;

        parent::__construct($config);
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
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->load($data);

        return true;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function createRole()
    {
        $role = $this->authManager->createRole(
            mb_strtolower($this->roleName)
        );

        $role->description = $this->roleDescription;

        if (!$this->authManager->add($role)) {
            $this->addError('roleName', 'Не удается добавить роль в систему');
            return false;
        }

        return true;
    }
}