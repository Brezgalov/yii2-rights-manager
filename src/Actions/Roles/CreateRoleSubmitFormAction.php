<?php

namespace Brezgalov\RightsManager\Actions\Roles;

use Brezgalov\RightsManager\Pages\CreateRolePage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\Formatters\RenderOrRedirectFormatter;
use Brezgalov\ApiHelpers\v2\RenderAction;
use yii\helpers\Url;

class CreateRoleSubmitFormAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = CreateRolePage::class;

    /**
     * @var string
     */
    public $methodName = CreateRolePage::SUBMIT_ROLE_METHOD;

    /**
     * @var string
     */
    public $title = 'Добавить новую роль';

    /**
     * @var string
     */
    public $view = 'Roles/Create';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;

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
            'redirectUrl' => Url::toRoute('roles/list'),
        ];

        parent::__construct($id, $controller, $config);
    }
}