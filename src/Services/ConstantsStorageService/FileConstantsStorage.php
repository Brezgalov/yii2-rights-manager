<?php

namespace Brezgalov\RightsManager\Services\ConstantsStorageService;

use Brezgalov\RightsManager\RightsManagerModule;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\rbac\ManagerInterface;

class FileConstantsStorage extends Component implements IConstantsStorageService
{
    /**
     * @var string
     */
    public $rolePrefix = 'ROLE_';

    /**
     * @var string
     */
    public $permissionPrefix = 'PREFIX_';

    /**
     * @var string
     */
    public $configPath;

    /**
     * @var array
     */
    protected $constants = [];

    /**
     * FileConstantsStorage constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        if (empty($this->configPath)) {
            $this->configPath = RightsManagerModule::getConstantsFileConfigPath();
        }

        if (empty($this->configPath)) {
            throw new InvalidConfigException('configPath should be set');
        }
    }

    /**
     * @param ManagerInterface $authManager
     * @return IConstantsStorageService
     */
    public function loadCurrentData(ManagerInterface $authManager)
    {
        if (empty($authManager)) {
            $authManager = \Yii::$app->authManager;
        }

        foreach ($authManager->getRoles() as $role) {
            $this->addRoleConstant($role->name);
        }

        foreach ($authManager->getPermissions() as $permission) {
            $this->addPermissionConstant($permission->name);
        }

        return $this;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function addRoleConstant(string $value)
    {
        $name = strtoupper("{$this->rolePrefix}{$value}");

        $this->constants[$name] = $value;

        return true;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function addPermissionConstant(string $value)
    {
        $name = strtoupper("{$this->permissionPrefix}{$value}");

        $this->constants[$name] = $value;

        return true;
    }

    /**
     * @return bool
     */
    public function flush()
    {
        $filePath = \Yii::getAlias($this->configPath);
        FileHelper::createDirectory(dirname($filePath));

        $contents = "<?php\n\n";

        foreach ($this->constants as $name => $value) {
            $name = mb_strtoupper($name);

            $contents .= "defined(\"{$name}\") or define(\"{$name}\", \"{$value}\");\n";
        }

        return (bool)file_put_contents($filePath, $contents);
    }
}