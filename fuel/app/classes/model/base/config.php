<?php

use Fuel\Core\Log;
use Fuel\Core\Date;

class Model_Base_Config
{

    public static function update($data)
    {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s', Date::forge()->get_timestamp());
            $query = Model_Config::find(1);
            $query->set($data);
            $query->save();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

}
