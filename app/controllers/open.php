<?php

$app->get('/open/session', function () use ($app) {
    $code     = $app->request->getQuery('code');
    $wxconfig = $app->config->wxconfig;
    return $app->util->getWxSessionId($app, $wxconfig['appid'], $wxconfig['appsecret'], $code);
});





