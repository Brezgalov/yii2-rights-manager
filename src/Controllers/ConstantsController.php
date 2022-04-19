<?php

namespace Brezgalov\RightsManager\Controllers;

use Brezgalov\RightsManager\Actions\Constants\UpdateStorageAction;
use yii\web\Controller;

class ConstantsController extends Controller
{
    /**
     * @return string[]
     */
    public function actions()
    {
        return [
            'update-storage' => UpdateStorageAction::class,
        ];
    }
}