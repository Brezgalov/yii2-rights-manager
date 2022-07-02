<?php

use Brezgalov\RightsManager\Services\CreateRoleService;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var CreateRoleService $createRoleService
 * @var string $submitFormUrl
 * @var View $this
 * @var bool $refreshConstants
 */

?>

<div>
    <h2><?= $this->title ?></h2>
</div>
<div>
    <?php $form = ActiveForm::begin([
        'action' => Url::toRoute($submitFormUrl),
    ]) ?>

    <?= $form->field($createRoleService, 'roleName')->label('Название / Код роли') ?>

    <?= $form->field($createRoleService, 'roleDescription')->label('Описание') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
