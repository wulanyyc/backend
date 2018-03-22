<?php

return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'username' => 'root',
        'password' => 'testmysql123',
        'dbname' => 'Shops',
        'options' => [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ],
    ],
    'logger' => ['path' => __DIR__ . '/../logs/app.log'],
    'redis' => [
        'tcp://127.0.0.1',
    ],
    'mapper' => [],
    'salt' => 'yyctest',
    'deploy' => 'testing',
    'picture' => [
        'path' => __DIR__ . "/../../public/upload/",
    ],
    'wxconfig' => require(__DIR__ . "/wx.php"),
];
