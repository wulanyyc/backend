<?php
use Shop\Model\Shops;
use Shop\Model\Users;

// TODO店铺唯一性检测
$app->post('/shop/add', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);
    $userInfo = $app->util->getUser($app, $params['session']);
    $openid   = $userInfo['openid'];
    $user = Users::findFirst(['openid' => $openid]);
    $uid  = $user->id;

    unset($params['session']);

    $ar = new Shops();
    $ar->uid = $uid;
    foreach($params as $key => $value) {
        $ar->$key = $value;
    }

    if ($ar->save() == true) {
        return $ar->id;
    } else {
        return 0;
    }
});
