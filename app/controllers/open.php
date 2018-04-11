<?php
use Shop\Model\Users;
use Shop\Model\Shops;

$app->get('/open/session', function () use ($app) {
    $code     = $app->request->getQuery('code');
    $wxconfig = $app->config['wxconfig'];

    $result = $app->util->getWxSessionId($app, $wxconfig['appid'], $wxconfig['appsecret'], $code);

    if (isset($result['session_key'])) {
        $key = md5($result['openid'] . $result['session_key']);
        $app->redis->setex($key, 86400, json_encode($result));

        $ret = [];
        $ret['session'] = $key;

        $userInfo = Users::findFirst('openid="' . $result['openid'] . '"')->toArray();
        if (empty($userInfo)) {
            $ar = new Users();
            $ar->openid = $result['openid'];
            $ar->unionid = $result['unionid'];
            $ar->save();

            $ret['uid'] = $ar->id;
        } else {
            $ret['uid'] = $userInfo['id'];
        }

        return $ret;
    } else {
        return '';
    }
});


$app->get('/open/banks', function () use ($app) {
    return $app->config->banks;
});