<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Formatters\RemoveAuthItemServicePjaxAdapter;
use Brezgalov\RightsManager\Pages\Permissions\PermissionsListPage;
use Brezgalov\RightsManager\Pages\Roles\RolesListPage;
use Brezgalov\RightsManager\Services\RemoveAuthItemService;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\LoadServiceFromModuleBehavior;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\TransactionBehavior;
use Brezgalov\ApiHelpers\v2\RenderAction;

class RemoveRolePjaxAction extends RenderAction
{
    const BEHAVIOR_KEY_TRANSACTION = 'transaction';

    /**
     * @var bool
     */
    public $layout = false;

    /**
     * @var string
     */
    public $methodName = RemoveAuthItemService::MAIN_METHOD;

    /**
     * @var string
     */
    public $view = 'Roles/List/GridView';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;

    /**
     * @var string
     */
    public $formatter = [
        'class' => RemoveAuthItemServicePjaxAdapter::class,
        'pageService' => RolesListPage::class,
        'pageInitMethod' => RolesListPage::PAGE_PREPARE_METHOD,
    ];

    /**
     * @var array
     */
    public $behaviors = [
        TransactionBehavior::class,
    ];

    /**
     * DeletePermissionPjaxAction constructor.
     * @param $id
     * @param $controller
     * @param array $config
     */
    public function __construct($id, $controller, $config = [])
    {
        $this->service = [
            'class' => RemoveAuthItemService::class,
            'mode' => RemoveAuthItemService::getRoleMode(),
        ];

        parent::__construct($id, $controller, $config);
    }

    /**
     * @return array
     */
    protected function getDefaultBehaviors()
    {
        return [
            static::BEHAVIOR_KEY_TRANSACTION => TransactionBehavior::class,
            LoadServiceFromModuleBehavior::class,
        ];
    }
}