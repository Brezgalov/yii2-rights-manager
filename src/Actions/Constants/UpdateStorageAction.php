<?php

namespace Brezgalov\RightsManager\Actions\Constants;

use Brezgalov\RightsManager\Services\RefreshConstantsStorageService;
use Brezgalov\ApiHelpers\v2\ApiPostAction;
use Brezgalov\ApiHelpers\v2\Formatters\RedirectBackFormatter;

class UpdateStorageAction extends ApiPostAction
{
    /**
     * @var string
     */
    public $service = RefreshConstantsStorageService::class;

    /**
     * @var string
     */
    public $methodName = RefreshConstantsStorageService::MAIN_METHOD;

    /**
     * @var string
     */
    public $formatter = RedirectBackFormatter::class;
}