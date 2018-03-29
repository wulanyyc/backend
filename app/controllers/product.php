<?php
use Shop\Model\Products;

$app->post('/product/add', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);

    $ar = new Products();
    $ar->main_img = $params['img_list'][0];
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
});


$app->get('/product/info/{id:\d+}', function ($id) use ($app) {
    $result = Products::findFirst(['id' => $id]);
    return $result;
});
