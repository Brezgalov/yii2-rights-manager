<?php

namespace Brezgalov\RightsManager\Formatters;

use Brezgalov\ApiHelpers\v2\Formatters\ViewResultFormatter;
use Brezgalov\ApiHelpers\v2\IFormatter;

class RemoveAuthItemServicePjaxAdapter extends ViewResultFormatter implements IFormatter
{
    /**
     * @var string|array
     */
    public $pageService;

    /**
     * @var string
     */
    public $pageInitMethod;

    /**
     * @param object $service
     * @param mixed $result
     * @return false|mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function format($service, $result)
    {
        $pageService = \Yii::createObject($this->pageService);

        if ($this->pageInitMethod) {
            call_user_func([$pageService, $this->pageInitMethod]);
        }

        return parent::format($pageService, $pageService);
    }
}