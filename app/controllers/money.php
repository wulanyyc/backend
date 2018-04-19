<?php
use Shop\Model\UserCards;
use Shop\Model\Users;

//用户认证（手机动态登录）
$app->get('/money/init/{id:\d+}', function ($id) use ($app) {
    $result = UserCards::findFirst(['uid' => $id]);

    if (!$result) {
        $card = $result->toArray();
    } else {
        $card = [];
    }

    $userInfo = Users::findFirst($id);

    return [
        'card' => $card,
        'money' => $userInfo->money,
    ];
});
