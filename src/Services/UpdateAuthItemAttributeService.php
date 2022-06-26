<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\Dto\EditableColumnDto;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\rbac\Item;
use yii\rbac\ManagerInterface;
use yii\rbac\Permission;
use yii\rbac\Role;

class UpdateAuthItemAttributeService extends Model implements IRegisterInputInterface
{
    const MAIN_METHOD = 'updateAttribute';

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
     * @var string
     */
    public $attributeName;

    /**
     * @var string
     */
    public $attributeValue;

    /**
     * Список атрибутов доступных к редактированию
     * @var array
     */
    public $attributesAllowed;

    /**
     * @var ManagerInterface
     */
    public $authManager;

    /**
     * UpdatePermissionAttributeService constructor.
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
        $rules = [
            [['authItemName', 'attributeName'], 'required'],
        ];

        if (is_array($this->attributesAllowed)) {
            $rules[] = ['attributeName', 'in', 'range' => $this->attributesAllowed];
        }

        return $rules;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function registerInput(array $data = [])
    {
        $this->authItemName = $data['editableKey'] ?? $this->attributeName;
        $this->attributeName = $data['editableAttribute'] ?? $this->attributeName;

        if ($this->attributeName) {
            $this->attributeValue = $data[$this->attributeName] ?? $this->attributeValue;
        }

        return true;
    }

    /**
     * @return EditableColumnDto
     * @throws \Exception
     */
    public function updateAttribute()
    {
        if (!$this->validate()) {
            $summary = $this->getErrorSummary(false);

            return new EditableColumnDto(['message' => array_shift($summary) ?: 'Неизвестная ошибка валидации']);
        }

        $authItem = $this->getAuthItem();
        if (empty($authItem)) {
            return new EditableColumnDto(['message' => 'Не удается найти ' . $this->getAuthItemErrorName() . ' для редактирования']);
        }

        $authItem->{$this->attributeName} = $this->attributeValue;

        if (!$this->authManager->update($this->authItemName, $authItem)) {
            return new EditableColumnDto(['message' => 'Не удается сохранить ' . $this->getAuthItemErrorName()]);
        }

        return new EditableColumnDto(['output' => $this->attributeValue]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getAuthItemErrorName()
    {
        return ArrayHelper::getValue([
            static::PERMISSION_MODE => 'разрешение',
            static::ROLE_MODE => 'роль',
        ], $this->mode, '?');
    }

    /**
     * @return Role|Permission
     * @throws InvalidConfigException
     */
    public function getAuthItem()
    {
        $method = ArrayHelper::getValue([
            static::PERMISSION_MODE => 'getPermission',
            static::ROLE_MODE => 'getRole',
        ], $this->mode);

        if (empty($method)) {
            throw new InvalidConfigException("Mode setup is incorrect");
        }

        return call_user_func([$this->authManager, $method], $this->authItemName);
    }
}