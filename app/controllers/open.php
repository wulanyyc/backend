<?php
use Shop\Model\Users;
use Shop\Model\Shops;

$app->get('/open/session', function () use ($app) {
    $code     = $app->request->getQuery('code');
    $wxconfig = $app->config['wxconfig'];

    $result = $app->util->getWxSessionId($app, $wxconfig['appid'], $wxconfig['appsecret'], $code);

    if (isset($result['session_key'])) {
        $userInfo = Users::findFirst(['openid' => $result['openid']]);
        $key = md5($result['openid'] . $result['session_key']);
        $app->redis->setex($key, 86400 * 2, json_encode($result));

        $ret = [];
        $ret['session'] = $key;
        if (!empty($userInfo)) {
            $ret['uid'] = $userInfo->id;
        }

        return $ret;
    } else {
        return '';
    }
});


$app->post('/open/phone', function () use ($app) {
    $params = json_decode($app->request->getRawBody(), true);

    $user = $app->util->getUser($app, $params['session']);
    $pc = new WxBizDataCrypt($app->config->wxconfig['appid'], $user['session_key']);
    $errCode = $pc->decryptData($params['encryptedData'], $params['iv'], $data);

    if ($errCode == 0) {
        $ret = json_decode($data, true);
        return $ret['purePhoneNumber'];
    } else {
        return $errCode;
    }
});

// 用户上传
$app->post('/open/upload', function () use ($app) {
    $uploader = new FileUploader($app);
    return $uploader->upload();
});
