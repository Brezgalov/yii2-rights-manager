<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Services\UpdateAuthItemAttributeService;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use Brezgalov\ApiHelpers\v2\Formatters\RestFormatter;

class UpdateRoleAttributeAction extends ApiPostAction
{
    /**
     * @var array
     */
    public $service = [
        'class' => UpdateAuthItemAttributeService::class,
        'mode' => UpdateAuthItemAttributeService::ROLE_MODE,
    ];

    /**
     * @var string
     */
    public $methodName = UpdateAuthItemAttributeService::MAIN_METHOD;

    /**
     * @var string
     */
    public $formatter = RestFormatter::class;
}