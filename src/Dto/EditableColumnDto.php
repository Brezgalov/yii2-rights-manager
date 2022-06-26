<?php

namespace Brezgalov\RightsManager\Dto;

use yii\base\Model;

class EditableColumnDto extends Model
{
    /**
     * @var string
     */
    public $output = '';

    /**
     * @var string
     */
    public $message = '';
}