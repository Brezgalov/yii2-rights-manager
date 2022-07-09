<?php

defined('RIGHTS_MANAGER_COMP_NAME') or define('RIGHTS_MANAGER_COMP_NAME', 'rights-manager-dev');

return [
    'id' => 'testApp',
    'basePath' => __DIR__ . '/../',
    'bootstrap' => [
        RIGHTS_MANAGER_COMP_NAME
    ],
    'components' => [
        'authManager' => [
            'class' => \yii\rbac\PhpManager::class,
            'itemFile' => DIR_GENERATED . '/items.php',
            'assignmentFile' => DIR_GENERATED . '/assignments.php',
            'ruleFile' => DIR_GENERATED . '/rules.php',
        ],
        RIGHTS_MANAGER_COMP_NAME => [
            'class' => \Brezgalov\RightsManager\RightsManagerModule::class,
            'constantsStorageServiceSetup' => [
                'class' => \Brezgalov\RightsManager\Services\ConstantsStorageService\FileConstantsStorage::class,
                'configPath' => DIR_GENERATED . '/rbac_constants.php',
            ],
        ],
    ],
];