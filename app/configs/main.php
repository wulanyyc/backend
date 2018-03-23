<?php

return [
    'db' => require(__DIR__ . "/db.php"),
    'logger' => ['path' => __DIR__ . '/../logs/app.log'],
    'redis' => [
        'tcp://127.0.0.1',
    ],
    'mapper' => [],
    'salt' => 'yyctest',
    'picture' => [
        'path' => __DIR__ . "/../../public/upload/",
    ],
    'wxconfig' => require(__DIR__ . "/wx.php"),
];
