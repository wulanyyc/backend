<?php
use Shop\Model\Users;

$app->get('/open/session', function () use ($app) {
    $code     = $app->request->getQuery('code');
    $wxconfig = $app->config['wxconfig'];

    $result = $app->util->getWxSessionId($app, $wxconfig['appid'], $wxconfig['appsecret'], $code);

    if (isset($result['session_key'])) {
        $exsit = Users::find(['openid' => $result['openid']]);
        if (count($exsit) == 0) {
            $ar = new Users();
            $ar->openid  = $result['openid'];
            $ar->unionid = $result['unionid'];
            $ar->save();
        }

        $key = md5($result['openid'] . $result['session_key']);
        $app->redis->setex($key, 86400 * 7, $result['openid'] . '_' . $result['session_key']);

        return $key;
    } else {
        return '';
    }
});


$app->post('/open/phone', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);

    $user = $app->util->getUser($app, $params['session']);
    return $user;

    $pc = new WxBizDataCrypt($app->config->wxconfig['appid'], $user[1]);
    $errCode = $pc->decryptData($params['encryptedData'], $params['iv'], $data);

    if ($errCode == 0) {
        return $data;
    } else {
        return $errCode;
    }
});