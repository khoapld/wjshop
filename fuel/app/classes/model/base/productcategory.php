<?php

use Fuel\Core\Log;

class Model_Base_ProductCategory
{

    public static function insert($product_id, $category_ids)
    {
        try {
            $props = array();
            $category_ids = explode(',', $category_ids);
            foreach ($category_ids as $category_id) {
                $props[] = array(
                    $product_id,
                    $category_id
                );
            }

            return Model_ProductCategory::insert($props);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }
    }

    public static function update($product_id, $category_ids)
    {
        try {
            Model_ProductCategory::query()->where(array('product_id' => $product_id))->delete();
            $props = array();
            $category_ids = explode(',', $category_ids);
            foreach ($category_ids as $category_id) {
                $props[] = array(
                    $product_id,
                    $category_id
                );
            }

            return Model_ProductCategory::insert($props);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }
    }

    public static function get_by($column, $field, $val)
    {
        $data = array();
        $product_categories = Model_ProductCategory::query()->select($column)->where(array($field => $val))->get();
        foreach ($product_categories as $product_category) {
            $data[] = $product_category->{$column};
        }

        return $data;
    }

    public static function exist($product_id, $category_id)
    {
        $query = Model_ProductCategory::query()->where(array('product_id' => $product_id, 'category_id' => $category_id));
        return ($query->count() > 0);
    }

}
