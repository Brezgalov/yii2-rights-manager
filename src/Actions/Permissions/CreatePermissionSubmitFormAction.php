<?php

namespace Brezgalov\RightsManager\Actions\Permissions;

use Brezgalov\RightsManager\Pages\Permissions\CreatePermissionPage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Behaviors\Action\TransactionBehavior;
use Brezgalov\ApiHelpers\v2\Formatters\RenderOrRedirectFormatter;
use Brezgalov\ApiHelpers\v2\RenderAction;
use yii\helpers\Url;

class CreatePermissionSubmitFormAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = CreatePermissionPage::class;

    /**
     * @var string
     */
    public $methodName = CreatePermissionPage::SUBMIT_PERMISSION_METHOD;

    /**
     * @var string
     */
    public $title = 'Добавить новое разрешение';

    /**
     * @var string
     */
    public $view = 'Permissions/Create';

    /**
     * @var string
     */
    public $successRedirectRoute = 'permissions/';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;

    /**
     * @var array
     */
    public $behaviors = [
        TransactionBehavior::class,
    ];

    /**
     * CreateRoleSubmitFormAction constructor.
     * @param $id
     * @param $controller
     * @param array $config
     */
    public function __construct($id, $controller, $config = [])
    {
        $this->formatter = [
            'class' => RenderOrRedirectFormatter::class,
            'redirectUrl' => Url::toRoute($this->successRedirectRoute),
        ];

        parent::__construct($id, $controller, $config);
    }
}