<?php
use Shop\Model\Products;
use Shop\Model\Users;

$app->get('/product/list/{id:\d+}', function ($id) use ($app) {
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
        'money' => $userInfo->money,
        'productCategory' => $productCategory,
        'productNum' => $productNum,
    ];
});

$app->post('/product/edit', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);
    $auditFlag = $app->util->getAuditFlag($params['uid']);

    if ($params['id'] == 0){
        $ar = new Products();
        $ar->main_img = $params['img_list'][0];
        if ($auditFlag == 1) {
            $ar->status = 1;
        }
        foreach($params as $key => $value) {
            if (!empty($value)) {
                if ($key == 'img_list') {
                    $ar->$key = json_encode($value);
                } else {
                    $ar->$key = $value;
                }
            }
        }

        if ($ar->save()) {
            return $ar->id;
        } else {
            return 0;
        }
    } else {
        $ar = Products::findFirst($params['id']);
        unset($params['id']);
        $ar->main_img = $params['img_list'][0];
        if ($auditFlag == 1) {
            $ar->status = 1;
        }

        foreach($params as $key => $value) {
            if (!empty($value)) {
                if ($key == 'img_list') {
                    $ar->$key = json_encode($value);
                } else {
                    $ar->$key = $value;
                }
            }
        }

        if ($ar->save()) {
            return $ar->id;
        } else {
            return 0;
        }
    }
});


$app->get('/product/info/{id:\d+}', function ($id) use ($app) {
    $result = Products::findFirst($id);
    return $result;
});

$app->get('/product/sale/{id:\d+}', function ($id) use ($app) {
    $result = Products::findFirst($id);
    $result->status = 1;
    $result->save();
    return $result->id;
});

$app->get('/product/unsale/{id:\d+}', function ($id) use ($app) {
    $result = Products::findFirst($id);
    $result->status = 2;
    $result->save();
    return $result->id;
});

$app->get('/product/del/{id:\d+}', function ($id) use ($app) {
    $result = Products::findFirst($id);
    $result->status = 3;
    $result->save();
    return $result->id;
});
