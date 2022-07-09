<?php

require_once __DIR__ . '/../vendor/autoload.php';

defined('YII_ENV') or define('YII_ENV', 'test');
defined('YII_DEBUG') or define('YII_DEBUG', true);

defined('DIR_GENERATED') or define('DIR_GENERATED', __DIR__ . '/Generated');

require_once __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/Config/test.php';

$app = new \yii\console\Application($config);

$touchFiles = [
    DIR_GENERATED . '/items.php',
    DIR_GENERATED . '/assignments.php',
    DIR_GENERATED . '/rules.php',
    DIR_GENERATED . '/rbac_constants.php',
];

//foreach ($touchFiles as $filePath) {
//    if (!is_file($filePath)) {
//        file_put_contents($filePath, "<?php return [];");
//    }
//}