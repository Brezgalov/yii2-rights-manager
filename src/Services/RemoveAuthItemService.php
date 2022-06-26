<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\Helpers\AuthManagerHelper;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission;
use yii\rbac\Role;

class RemoveAuthItemService extends Model implements IRegisterInputInterface
{
    const MAIN_METHOD = 'removeAuthItem';

    const ROLE_MODE = 'roleMode';
    const PERMISSION_MODE = 'permissionMode';

    /**
     * @var string
     */
    public $mode;

    /**
     * @var string
     */
    public $authItemName;

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * @var AuthManagerHelper
     */
    public $authManagerHelper;

    /**
     * @return string
     */
    public static function getPermissionMode()
    {
        return AuthManagerHelper::PERMISSION;
    }

    /**
     * @return string
     */
    public static function getRoleMode()
    {
        return AuthManagerHelper::ROLE;
    }

    /**
     * RemoveAuthItemService constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->authManager)) {
            $this->authManager = \Yii::$app->authManager;
        }

        if (empty($this->authManagerHelper)) {
            $this->authManagerHelper = new AuthManagerHelper(['authManager' => $this->authManager]);
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['authItemName', 'mode'], 'required'],
        ];
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->authItemName = $data['id'] ?? $this->authItemName;

        return true;
    }

    /**
     * @return bool
     * @throws InvalidConfigException
     */
    public function removeAuthItem()
    {
        if (!$this->validate()) {
            return false;
        }

        /** @var Permission|Role $authItem */
        $authItem = $this->authManagerHelper->getAuthItem($this->authItemName, $this->mode);
        if (empty($authItem)) {
            $this->addError('authItemName', 'Не удается найти '
                . $this->authManagerHelper->getAuthItemErrorName($this->mode)
                . ' '
                . $this->authItemName
            );
            return false;
        }

        if (!$this->authManager->remove($authItem)) {
            $this->addError('authItemName', 'Не удается удалить '
                . $this->authManagerHelper->getAuthItemErrorName($this->mode)
                . ' '
                . $this->authItemName
            );
            return false;
        }

        return true;
    }
}