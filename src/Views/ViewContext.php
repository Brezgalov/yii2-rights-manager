<?php

namespace Brezgalov\RightsManager\Views;

use yii\base\ViewContextInterface;

class ViewContext implements ViewContextInterface
{
    /**
     * @return string the view path that may be prefixed to a relative view name.
     */
    public function getViewPath()
    {
        return __DIR__;
    }
}