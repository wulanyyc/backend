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

