<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\rbac\Rule;
use kartik\select2\Select2;
use Brezgalov\RightsManager\Services\CreatePermissionService;

/**
 * @var CreatePermissionService $createPermissionService
 * @var string[] $rulesList
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

    <?= $form->field($createPermissionService, 'permissionName')->label('Название / Код разрешения') ?>

    <?= $form->field($createPermissionService, 'ruleName')->widget(Select2::class, [
        'data' => $rulesList,
        'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Правило (yii\rbac\Rule)') ?>

    <?= $form->field($createPermissionService, 'permissionDescription')->label('Описание') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>

