<?php

namespace Brezgalov\RightsManager\Services;

use Brezgalov\RightsManager\Dto\EditableColumnDto;
use Brezgalov\RightsManager\Helpers\AuthManagerHelper;
use Brezgalov\ApiHelpers\v2\IRegisterInputInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\rbac\ManagerInterface;

class UpdateAuthItemAttributeService extends Model implements IRegisterInputInterface
{
    const MAIN_METHOD = 'updateAttribute';

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
     * UpdatePermissionAttributeService constructor.
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
        $rules = [
            [['authItemName', 'attributeName', 'mode'], 'required'],
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
        $this->authItemName = $data['editableKey'] ?? $this->authItemName;
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

        $authItem = $this->authManagerHelper->getAuthItem($this->authItemName, $this->mode);
        if (empty($authItem)) {
            return new EditableColumnDto([
                'message' => 'Не удается найти '
                    . $this->authManagerHelper->getAuthItemErrorName($this->mode)
                    . ' для редактирования',
            ]);
        }

        $authItem->{$this->attributeName} = $this->attributeValue;

        if (!$this->authManager->update($this->authItemName, $authItem)) {
            return new EditableColumnDto([
                'message' => 'Не удается сохранить ' . $this->authManagerHelper->getAuthItemErrorName($this->mode)
            ]);
        }

        return new EditableColumnDto(['output' => $this->attributeValue]);
    }
}