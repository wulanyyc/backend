<?php
use Shop\Model\UserCards;
use Shop\Model\Users;

//用户认证（手机动态登录）
$app->get('/money/init/{id:\d+}', function ($id) use ($app) {
    $result = UserCards::find(['uid' => $id]);
    $userInfo = Users::findFirst($id);

    $arr = $app->util->objectToArray($result);

    return [
        'cards' => $arr,
        'money' => $userInfo->money,
        'banks' => $app->config->banks,
    ];
});
