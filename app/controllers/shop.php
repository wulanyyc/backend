<?php
use Shop\Model\Products;
use Shop\Model\Users;

$app->get('/shop/info/{id:\d+}', function ($id) use ($app) {
    $userInfo = Users::findFirst($id);

    $ar = new Products();
    $product = $ar->getModelsManager()->executeQuery("select * from Products where uid=" . $id . ' and status != 3');
    $productNum = count($product);
    $productCategory = [];
    if ($productNum > 0) {
        foreach($product as $value) {
            $productCategory[$value->status][] = $value;
        }
    }

    return [
        'name' => $userInfo->name,
        'logo' => $userInfo->logo,
        'money' => $userInfo->money,
        'productCategory' => $productCategory,
        'productNum' => $productNum,
    ];
});
