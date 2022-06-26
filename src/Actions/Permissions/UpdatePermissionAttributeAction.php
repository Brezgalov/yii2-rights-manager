<?php

namespace Brezgalov\RightsManager\Actions\Permissions;

use Brezgalov\RightsManager\Services\UpdateAuthItemAttributeService;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use Brezgalov\ApiHelpers\v2\Formatters\RestFormatter;

class UpdatePermissionAttributeAction extends ApiPostAction
{
    /**
     * @var string
     */
    public $methodName = UpdateAuthItemAttributeService::MAIN_METHOD;

    /**
     * @var string
     */
    public $formatter = RestFormatter::class;

    /**
     * UpdatePermissionAttributeAction constructor.
     * @param $id
     * @param $controller
     * @param array $config
     */
    public function __construct($id, $controller, $config = [])
    {
        $this->service = [
            'class' => UpdateAuthItemAttributeService::class,
            'mode' => UpdateAuthItemAttributeService::getPermissionMode(),
        ];

        parent::__construct($id, $controller, $config);
    }
}