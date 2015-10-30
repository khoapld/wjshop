<?php

use Fuel\Core\Fuel;
use Fuel\Core\Log;

class Model_Service_Facebook
{

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
