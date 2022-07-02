<?php

namespace Brezgalov\RightsManager\Services\ConstantsStorageService;

use yii\rbac\ManagerInterface;

interface IConstantsStorageService
{
    /**
     * @param ManagerInterface $authManager
     * @return IConstantsStorageService
     */
    public function loadCurrentData(ManagerInterface $authManager);

    /**
     * @param string $value
     * @return bool
     */
    public function addRoleConstant(string $value);

    /**
     * @param string $value
     * @return bool
     */
    public function addPermissionConstant(string $value);

    /**
     * @return bool
     */
    public function flush();
}