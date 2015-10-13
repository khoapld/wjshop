<?php

use Fuel\Core\Log;
use Fuel\Core\Date;

class Model_Base_Photo
{

    public static function insert($data)
    {
        try {
            $props = [
                'product_id' => $data['product_id'],
                'photo_name' => $data['photo_name'],
                'rank' => Model_Photo::query()->where(array('product_id' => $data['product_id']))->max('rank') + 1,
                'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
            ];

            $new = Model_Photo::forge($props);
            $new->save();
            return $new->id;
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }
    }

    public static function update($id, $data)
    {
        try {
            $data['updated_at'] = date('Y-m-d H:i:s', Date::forge()->get_timestamp());
            $query = Model_Photo::find($id);
            $query->set($data);
            $query->save();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

    public static function delete($id)
    {
        try {
            $query = Model_Photo::find($id);
            $query->delete();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_Photo::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

}
