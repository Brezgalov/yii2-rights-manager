<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\RightsManagerModule;
use Brezgalov\RightsManager\Services\ConstantsStorageService\FileConstantsStorage;
use Brezgalov\RightsManager\Services\ConstantsStorageService\IConstantsStorageService;
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
     * @var string|array|IConstantsStorageService|bool
     */
    public $constantsStorage;

    /**
     * CreateRoleService constructor.
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct($config = [])
    {
        $this->authManager = \Yii::$app->authManager;

        parent::__construct($config);

        if (is_null($this->constantsStorage)) {
            $storeConf = RightsManagerModule::getConstantsStorageServiceConfig();

            if ($storeConf) {
                $this->constantsStorage = \Yii::createObject($storeConf);
            } else {
                $this->constantsStorage = new FileConstantsStorage();
            }
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