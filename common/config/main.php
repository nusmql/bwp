<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'adminAuthManager' => [
        	'class' => 'yii\rbac\DbManager',
        	'assignmentTable' => 'admin_auth_item',
        	'itemChildTable' => 'admin_auth_item_child',
        	'itemTable' => 'admin_auth_item',
        	'ruleTable' => 'admin_auth_rule',
        ],
    ],
];
