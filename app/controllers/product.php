<?php
use Shop\Model\Products;

$app->post('/product/add', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);

    return $params;

    // $ar = new Products();
    // $ar->user_id = $id;
    // $ar->name = $params['name'];
    // $ar->product_category_id = $params['category'];
    // $ar->price_unit_id = $params['unit'];
    // $ar->price = $params['price'];
    // $ar->shop_id = $shopId;
    // $ar->pic_url = $params['pic'];
    // $ar->inventory = $params['sellnum'];
    // $ar->date = date("Ymd", time());

    // if (!$ar->save()) {
    //     return $ar->getMessages();
    // } else {
    //     return 'ok';
    // }
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
