<?php

namespace Brezgalov\RightsManager\Actions\RightsTable;

use Brezgalov\RightsManager\Pages\RightsTablePage;
use Brezgalov\RightsManager\Views\ViewContext;
use Brezgalov\ApiHelpers\v2\RenderAction;

class IndexAction extends RenderAction
{
    /**
     * @var string
     */
    public $service = RightsTablePage::class;

    /**
     * @var string
     */
    public $methodName = RightsTablePage::PAGE_PREPARE_METHOD;

    /**
     * @var string
     */
    public $title = 'Таблица ролей и разрешений';

    /**
     * @var string
     */
    public $view = 'RightsTable/View';

    /**
     * @var string
     */
    public $viewContext = ViewContext::class;
}