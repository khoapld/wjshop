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
                'product_info' => $data['product_info'],
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

    public static function get_by($option = array())
    {
        try {
            $product = Model_Product::find('all', array(
                    'select' => !empty($option['select']) ? $option['select'] : array(),
                    'where' => !empty($option['where']) ? $option['where'] : array(),
                    'order_by' => !empty($option['order_by']) ? $option['order_by'] : array('id' => 'desc'),
                    'offset' => !empty($option['offset']) ? $option['offset'] : _DEFAULT_OFFSET_,
                    'limit' => !empty($option['limit']) ? $option['limit'] : _DEFAULT_LIMIT_
            ));
            return self::map_product($product);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function count_by($option = array())
    {
        $select = !empty($option['select']) ? $option['select'] : array();
        $where = !empty($option['where']) ? $option['where'] : array();
        $order_by = !empty($option['order_by']) ? $option['order_by'] : array('id' => 'desc');
        $query = Model_Product::query()->select($select)->where($where)->order_by($order_by);
        return $query->count();
    }

    public static function get_one($id, $option = array())
    {
        try {
            $product = Model_Product::find('all', array(
                    'select' => !empty($option['all']) ? $option['select'] : array(),
                    'where' => !empty($option['where']) ? array_merge(array(array('id' => $id)), $option['where']) : array('id' => $id),
                    'order_by' => !empty($option['order_by']) ? $option['order_by'] : array('id' => 'desc')
            ));
            return self::map_product($product)[$id];
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function admin_get_by_category($category_id, $offset = _DEFAULT_OFFSET_, $limit = _DEFAULT_LIMIT_)
    {
        $category_ids = Model_Base_Category::get_all_child_category_id($category_id);
        $ids = join(',', $category_ids);
        $sql = "
                SELECT `p`.*
                FROM `product_categories` `pc`
                LEFT JOIN `products` `p` ON `pc`.`product_id` = `p`.`id`
                WHERE `pc`.`category_id` IN ($ids)
                GROUP BY `p`.`id`
                ORDER BY `p`.`id` DESC
                LIMIT $offset, $limit
            ";
        try {
            $product = DB::query($sql)->as_object()->execute();
            return self::map_product($product);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function admin_count_by_category($category_id)
    {
        $category_ids = Model_Base_Category::get_all_child_category_id($category_id);
        $ids = join(',', $category_ids);
        $sql = "
                SELECT `pc`.`product_id`
                FROM `product_categories` `pc`
                WHERE `pc`.`category_id` IN ($ids)
                GROUP BY `pc`.`product_id`
                ORDER BY `pc`.`product_id` DESC
            ";
        try {
            $query = DB::query($sql)->execute()->as_array();
            return count($query);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function get_by_category($category_id, $offset = _DEFAULT_OFFSET_, $limit = _DEFAULT_LIMIT_)
    {
        $category_ids = Model_Base_Category::get_all_child_category_id($category_id);
        $ids = join(',', $category_ids);
        $sql = "
                SELECT `p`.*
                FROM `product_categories` `pc`
                LEFT JOIN `products` `p` ON `pc`.`product_id` = `p`.`id`
                WHERE `pc`.`category_id` IN ($ids)
                AND `p`.`status` = 1
                GROUP BY `p`.`id`
                ORDER BY `p`.`id` DESC
                LIMIT $offset, $limit
            ";
        try {
            $product = DB::query($sql)->as_object()->execute();
            return self::map_product($product);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function count_by_category($category_id)
    {
        $category_ids = Model_Base_Category::get_all_child_category_id($category_id);
        $ids = join(',', $category_ids);
        $sql = "
                SELECT `p`.`id`
                FROM `product_categories` `pc`
                LEFT JOIN `products` `p` ON `pc`.`product_id` = `p`.`id`
                WHERE `pc`.`category_id` IN ($ids)
                AND `p`.`status` = 1
                GROUP BY `p`.`id`
            ";
        try {
            $query = DB::query($sql)->execute()->as_array();
            return count($query);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function get_by_category_ids($category_ids, $offset = _DEFAULT_OFFSET_, $limit = _DEFAULT_LIMIT_)
    {
        $ids = join(',', $category_ids);
        $sql = "
                SELECT `p`.*
                FROM `product_categories` `pc`
                LEFT JOIN `products` `p` ON `pc`.`product_id` = `p`.`id`
                WHERE `pc`.`category_id` IN ($ids)
                AND `p`.`status` = 1
                GROUP BY `p`.`id`
                ORDER BY `p`.`id` DESC
                LIMIT $offset, $limit
            ";
        try {
            $product = DB::query($sql)->as_object()->execute();
            return self::map_product($product);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
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
        foreach ($product as $v) {
            $data[$v->id]['id'] = $v->id;
            $data[$v->id]['product_name'] = $v->product_name;
            $data[$v->id]['product_description'] = !empty($v->product_description) ? $v->product_description : '';
            $data[$v->id]['product_info'] = !empty($v->product_info) ? $v->product_info : '';
            $data[$v->id]['product_photo'] = !empty($v->product_photo) ? $v->product_photo : '';
            $data[$v->id]['product_photo_display'] = empty($v->product_photo) ? _PATH_NO_IMAGE_ : _PATH_PRODUCT_ . $v->product_photo;
            $data[$v->id]['status'] = !empty($v->status) ? (int) $v->status : 2;
            $data[$v->id]['highlight'] = !empty($v->highlight) ? (int) $v->highlight : 0;
        }
        return $data;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_Product::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

}
