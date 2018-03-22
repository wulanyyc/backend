<?php

$app->get('/open/session', function () use ($app) {
    $code     = $app->request->get('code');
    $wxconfig = $app->config->wxconfig;
    return $app->util->getWxSessionId($wxconfig['appid'], $wxconfig['appsecret'], $code);
});





