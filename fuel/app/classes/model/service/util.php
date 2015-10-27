<?php

use Fuel\Core\Fuel;
use Fuel\Core\Config;
use Fuel\Core\Log;

class Model_Service_Util
{

    protected static $hasher = null;

    public static function mb_trim($str)
    {
        $str = trim(preg_replace('/(^\s+)|(\s+$)/us', '', $str));
        return preg_replace('/\t+/', ' ', $str);
    }

    public static function _empty($val)
    {
        return ($val === false or $val === null or $val === '' or $val === []);
    }

    public static function gen_code($code = null)
    {
        if ($code) {
            return md5($code . Config::get('auth.salt') . uniqid() . time());
        } else {
            return md5(Config::get('auth.salt') . uniqid() . time());
        }
    }

    public static function hash_password($password)
    {
        is_null(self::$hasher) and self::$hasher = new \PHPSecLib\Crypt_Hash();
        return base64_encode(self::$hasher->pbkdf2($password, Config::get('auth.salt'), Config::get('auth.iterations', 10000), 32));
    }

    public static function serverPost($url, $data, &$responseHeaders = null)
    {
        $query = http_build_query($data, '', '&');
        $stream = array('http' => array(
                'method' => 'POST',
                'header' => "Content-type: application/x-www-form-urlencoded",
                'content' => $query
        ));

        return self::httpRequest($url, $stream, $responseHeaders);
    }

    public static function httpRequest($url, $options = null, &$responseHeaders = null)
    {
        $context = null;
        if (!empty($options) && is_array($options)) {
            if (empty($options['http']['header'])) {
                $options['http']['header'] = "User-Agent: opauth";
            } else {
                $options['http']['header'] .= "\r\nUser-Agent: opauth";
            }
        } else {
            $options = array('http' => array('header' => 'User-Agent: opauth'));
        }
        $context = stream_context_create($options);
        $content = file_get_contents($url, false, $context);
        $responseHeaders = implode("\r\n", $http_response_header);

        return $content;
    }

    public static function get_app_config($name, $option = array())
    {
        $data = array();
        $config = Config::get('app.' . $name);
        foreach ($option as $key) {
            $data[$key] = $config[$key];
        }

        return !empty($option) ? $data : $config;
    }

    public static function feed_fb($token, $data)
    {
        $data = base64_encode(json_encode($data));
        $oil_path = str_replace('\\', '/', realpath(APPPATH . '/../../'));
        $command = "env FUEL_ENV=" . Fuel::$env . " php $oil_path/oil r tool:feed_fb '$token' '$data' > /dev/null &";
        try {
            exec($command);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
