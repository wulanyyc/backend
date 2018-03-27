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


$app->get('/product/list/{id:\d+}', function ($id) use ($app) {
    $result = Products::find([
        'conditions' => 'user_id = ' . $id . ' and deleteflag = 0',
        'order' => 'id desc',
        'columns' => 'id,product_category_id,price_unit_id,name,price,pic_url,inventory',
    ]);

    $data = [];
    foreach($result as $item) {
        $tmp = [];
        foreach($item as $k => $v) {
            $tmp[$k] = $v;

            if ($k == 'product_category_id') {
                $tmp[$k] = $app->db->fetchOne("select text from product_category where id=" . $v)['text'];
            }

            if ($k == 'price_unit_id') {
                $tmp[$k] = $app->db->fetchOne("select text from product_unit where id=" . $v)['text'];
            }
        }
        $data[] = $tmp;
    }

    return $data;
});
