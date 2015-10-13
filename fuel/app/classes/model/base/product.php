<?php

use Fuel\Core\Log;
use Fuel\Core\Date;

class Model_Base_Product
{

    public static function insert($data)
    {
        try {
            $props = [
                'product_name' => $data['product_name'],
                'product_description' => $data['product_description'],
                'status' => 2,
                'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
            ];

            $new = Model_Product::forge($props);
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
            $query = Model_Product::find($id);
            $query->set($data);
            $query->save();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

    public static function get_all($offset = _DEFAULT_OFFSET_, $limit = _DEFAULT_LIMIT_)
    {
        $product = Model_Product::find('all', array(
                'select' => array('product_name', 'product_description', 'product_photo', 'status'),
                'order_by' => array('id' => 'desc'),
                'offset' => $offset,
                'limit' => $limit
        ));

        return self::map_product($product);
    }

    public static function count_all()
    {
        return Model_Product::query()->count();
    }

    public static function get_by($field, $val)
    {
        $product = Model_Product::query()->where(array($field => $val))->get();
        return self::map_product($product)[$val];
    }

    public static function get_sub_photo($id)
    {
        $data = array();
        $sub_photo = Model_Photo::query()->select('photo_name')->where(array('product_id' => $id))->order_by(array('rank' => 'asc'))->get();
        foreach ($sub_photo as $photo) {
            $data[$photo->id]['l'] = _PATH_ROOT_PHOTO_ . 'l/' . $photo->photo_name;
            $data[$photo->id]['m'] = _PATH_ROOT_PHOTO_ . 'm/' . $photo->photo_name;
            $data[$photo->id]['s'] = _PATH_ROOT_PHOTO_ . 's/' . $photo->photo_name;
        }

        return $data;
    }

    public static function map_product($product)
    {
        $data = array();
        foreach ($product as $k => $v) {
            $data[$v->id]['id'] = $v->id;
            $data[$v->id]['product_name'] = $v->product_name;
            $data[$v->id]['product_description'] = $v->product_description;
            $data[$v->id]['product_photo'] = $v->product_photo;
            $data[$v->id]['product_photo_display'] = empty($v->product_photo) ? _PATH_NO_IMAGE_ : _PATH_PRODUCT_ . $v->product_photo;
            $data[$v->id]['status'] = (int) $v->status;
        }

        return $data;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_Product::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

}
