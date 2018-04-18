<?php
use Shop\Model\Products;
use Shop\Model\Users;
use Shop\Model\UserCards;

$app->get('/shop/info/{id:\d+}', function ($id) use ($app) {
    $userInfo = Users::findFirst($id);

    $product = Products::find("uid=" . $id . " and status != 3");
    $productNum = count($product);
    $productCategory = [];
    if ($productNum > 0) {
        foreach($product as $value) {
            $productCategory[$value->status][] = $value;
        }
    }

    return [
        'name' => $userInfo->shop_name ? $userInfo->shop_name : $userInfo->nick_name,
        'logo' => $userInfo->shop_avatar_url ? $userInfo->shop_avatar_url : $userInfo->avatar_url,
        'money' => $userInfo->money,
        'productCategory' => $productCategory,
        'productNum' => $productNum,
    ];
});


$app->get('/shop/edit/init/{id:\d+}', function ($id) use ($app) {
    $userInfo = Users::findFirst($id);

    return [
        'name' => $userInfo->shop_name ? $userInfo->shop_name : $userInfo->nick_name,
        'logo' => $userInfo->shop_avatar_url ? $userInfo->shop_avatar_url : $userInfo->avatar_url,
        'desc' => $userInfo->shop_desc
    ];
});


$app->post('/shop/edit/{id:\d+}', function ($id) use ($app) {
    $userInfo = Users::findFirst($id);

    $params = json_decode($app->request->getRawBody(), true);

    $userInfo->shop_name = $params['name'];
    $userInfo->shop_desc = $params['desc'];
    $userInfo->shop_avatar_url = $params['logo'];

    $userInfo->save();

    return 1;
});

$app->post('/shop/card/{id:\d+}', function ($id) use ($app) {
    $params = json_decode($app->request->getRawBody(), true);
    return $params;

    $userInfo = Users::findFirst($id);

    $uc = UserCards::findFirst("uid=" . $id);
    if (!$uc) {

        // throw new BusinessException(1000, "参数错误");
    } else {

    }
    return 1;
});