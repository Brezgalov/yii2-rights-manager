<?php

namespace Brezgalov\RightsManager\Dto;

use yii\base\Model;
use yii\rbac\Permission;
use yii\rbac\Role;

class RightsTableDto extends Model
{
    /**
     * @var int[][]
     */
    public $table;

    /**
     * @var Role[]
     */
    public $roles;

    /**
     * @var Permission[]
     */
    public $permissions;
}