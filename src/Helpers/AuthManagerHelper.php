<?php

namespace Brezgalov\RightsManager\Helpers;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission;
use yii\rbac\Role;

class AuthManagerHelper extends Component
{
    const ROLE = 'role';
    const PERMISSION = 'permission';

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * AuthManagerHelper constructor.
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
     * @param string $mode
     * @return string
     * @throws \Exception
     */
    public function getAuthItemErrorName(string $mode)
    {
        return ArrayHelper::getValue([
            static::PERMISSION => 'разрешение',
            static::ROLE => 'роль',
        ], $mode, '?');
    }

    /**
     * @param string $mode
     * @return Role|Permission|null
     * @throws InvalidConfigException
     */
    public function getAuthItem(string $authItemName, string $mode)
    {
        $method = ArrayHelper::getValue([
            static::PERMISSION => 'getPermission',
            static::ROLE => 'getRole',
        ], $mode);

        if (empty($method)) {
            throw new InvalidConfigException("Mode setup is incorrect");
        }

        return call_user_func([$this->authManager, $method], $authItemName);
    }
}