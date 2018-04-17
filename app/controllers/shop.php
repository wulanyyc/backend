<?php
use Shop\Model\Products;
use Shop\Model\Users;

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


$app->get('/shop/edit/{id:\d+}', function ($id) use ($app) {
    $userInfo = Users::findFirst($id);

    return [
        'name' => $userInfo->name,
        'logo' => $userInfo->logo,
        'desc' => $userInfo->desc
    ];
});