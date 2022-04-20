<?php

use Brezgalov\RightsManager\Dto\RightsTableDto;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

/* @var View $this */
/* @var RightsTableDto $tableDto */
/* @var string $submitRoute */

$rolesCount = $tableDto ? count($tableDto->roles) : 0;

?>

<h2><?= $this->title ?></h2>
<?php if (empty($tableDto)): ?>
    <p>Не найдено информации для отображения</p>
<?php else: ?>
    <form method="POST" action="<?= Url::toRoute($submitRoute) ?>">
        <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken(), []); ?>
        <table class="table table-responsive table-striped table-bordered">
            <thead>
            <tr>
                <th class="text-center bg-info" rowspan="2" style="width: 10%;">Разрешения</th>
                <th class="text-center" colspan="<?= $rolesCount ?>">Роли</th>
            </tr>
            <tr>
                <?php foreach ($tableDto->roles as $role): ?>
                    <th><?= $role->name ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($tableDto->permissions as $permission): ?>
                    <tr>
                        <td>
                            <div>
                                <b><?= $permission->name ?></b>
                            </div>
                            <?php if ($permission->description): ?>
                                <div>
                                        <span>
                                            <?= $permission->description ?>
                                        </span>
                                </div>
                            <?php endif; ?>
                        </td>
                        <?php foreach ($tableDto->roles as $role): ?>
                            <td>
                                <div>
                                    <?php $val = ArrayHelper::getValue($tableDto->table, "{$role->name}.{$permission->name}"); ?>
                                    <input
                                        type="checkbox"
                                        name="table[<?= $role->name ?>][<?= $permission->name ?>]"
                                        value="<?= $val ?>"
                                        <?= $val ? 'checked' : '' ?>
                                    />
                                </div>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-success">Сохранить</button>
    </form>
<?php endif; ?>