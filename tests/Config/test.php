<?php

return [
    'id' => 'testApp',
    'basePath' => __DIR__ . '/../',
    'bootstrap' => [
        'rights-manager-dev'
    ],
    'components' => [
        'authManager' => [
            'class' => \yii\rbac\PhpManager::class,
            'itemFile' => DIR_GENERATED . '/items.php',
            'assignmentFile' => DIR_GENERATED . '/assignments.php',
            'ruleFile' => DIR_GENERATED . '/rules.php',
        ],
        'rights-manager-dev' => [
            'class' => \Brezgalov\RightsManager\RightsManagerModule::class,
            'constantsStorageServiceSetup' => [
                'class' => \Brezgalov\RightsManager\Services\ConstantsStorageService\FileConstantsStorage::class,
                'configPath' => DIR_GENERATED . '/rbac_constants.php',
            ],
        ],
    ],
];