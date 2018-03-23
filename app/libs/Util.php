<?php

class Util
{
    public static function arrayToObject($array)
    {
        $object = new stdClass();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = self::arrayToObject($value);
            }
            $object->$key = $value;
        }
        return $object;
    }

    public static function objectToArray($obj)
    {   
        $data = [];
        if (is_object($obj)) {
            foreach ($obj as $key => $value) {
                if (is_object($value)) {
                    $value = self::objectToArray($value);
                }
                $data[$key] = $value;
            }
        }

        return $data;
    }

    /**
     * 从数组中获取数据
     * @param array $array    数据集
     * @param mixed $field    获取的键
     * @param mixed $default  无数据的默认值
     * @return mixed
     */
    public function arrayGet($array, $field, $default = null)
    {
        return isset($array[$field]) ? $array[$field] : $default;
    }

    public static function getWxSessionId($app, $appid, $secret, $code) {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='. $appid .'&secret='. $secret .'&js_code='. $code .'&grant_type=authorization_code';

        return $app->curl->get($url, 60);
    }

    public static function getUser($app, $session) {
        $result = $app->redis->get($session);
        return explode('_', $result);
    }
}
