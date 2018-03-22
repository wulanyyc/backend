<?php

$app->get('/open/session', function () use ($app) {
    $params   = $app->request->getGet();
    $wxconfig = $app->config->wxconfig;
    return $app->util->getWxSessionId($wxconfig['appid'], $wxconfig['appsecret'], $params['code']);
});





