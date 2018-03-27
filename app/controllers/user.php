<?php
use Shop\Model\Users;

//用户认证（手机动态登录）
$app->post('/user/add', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);

    $resultStr = $app->redis->get($params['session']);
    $result = json_decode($resultStr, true);

    unset($params['session']);

    $ar = new Users();
    $ar->openid  = $result['openid'];
    $ar->unionid = $result['unionid'];

    foreach($params as $key => $value) {
        $ar->$key = $value;
    }

    if ($ar->save() == true) {
        return $ar->id;
    } else {
        return 0;
    }
});


$app->post('/user/info', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);

    // $resultStr = $app->redis->get($params['session']);
    // $result = json_decode($resultStr, true);

    return $params;
});