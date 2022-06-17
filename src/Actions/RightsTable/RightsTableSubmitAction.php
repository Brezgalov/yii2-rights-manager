<?php

namespace Brezgalov\RightsManager\Actions\RightsTable;

use Brezgalov\RightsManager\Pages\RightsTablePage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\SubmitRenderAction;

class RightsTableSubmitAction extends SubmitRenderAction
{
    /**
     * @var string
     */
    public $service = RightsTablePage::class;

    /**
     * @var string
     */
    public $methodName = RightsTablePage::SUBMIT_TABLE_METHOD;

    /**
     * @var string
     */
    public $title = 'Таблица ролей и разрешений';

    /**
     * @var string
     */
    public $successRedirectRoute = 'rights-table/';

    /**
     * @var string
     */
    public $view = 'RightsTable/View';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;
}