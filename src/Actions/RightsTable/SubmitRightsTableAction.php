<?php

namespace Brezgalov\RightsManager\Actions\RightsTable;

use Brezgalov\RightsManager\Services\SubmitRightsTableService;
use Brezgalov\ApiHelpers\v2\Action;
use Brezgalov\ApiHelpers\v2\Formatters\RedirectBackFormatter;

class SubmitRightsTableAction extends Action
{
    /**
     * @var string
     */
    public $service = SubmitRightsTableService::class;

    /**
     * @var string
     */
    public $methodName = SubmitRightsTableService::MAIN_METHOD;

    /**
     * @var string
     */
    public $formatter = RedirectBackFormatter::class;
}