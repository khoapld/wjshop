<?php

use Fuel\Core\Log;
use Fuel\Core\Date;

class Model_Base_Category
{

    public static function insert($data)
    {
        try {
            $props = [
                'code' => Model_Service_Util::gen_code(),
                'parent_category_id' => !empty($data['parent_category_id']) ? $data['parent_category_id'] : 0,
                'category_name' => $data['category_name'],
                'rank' => Model_Category::query()->max('rank') + 1,
                'level' => $data['level'],
                'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
            ];

            $new = Model_Category::forge($props);
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
            $query = Model_Category::find($id);
            $query->set($data);
            $query->save();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

    public static function get_all($option = array())
    {
        try {
            $category = Model_Category::find('all', array(
                    'select' => !empty($option['select']) ? $option['select'] : array(),
                    'where' => !empty($option['where']) ? $option['where'] : array(),
                    'order_by' => !empty($option['order_by']) ? $option['order_by'] : array('rank' => 'asc')
            ));
            return self::map_category($category);
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function get_parent($parent_category_id = null)
    {
        $data = array();
        $category = Model_Category::query()
                ->select('parent_category_id', 'category_name', 'level')
                ->order_by('level', 'asc')->get();
        foreach ($category as $v) {
            $data[$v->id] = $v->category_name;
            if ($v->level != 1) {
                $data[$v->id] = $data[$v->parent_category_id] . ' / ' . $v->category_name;
            }
        }

        return $parent_category_id ? $data[$parent_category_id] : $data;
    }

    public static function map_category($category)
    {
        $data = array();
        $new_category = self::get_parent();
        foreach ($category as $v) {
            $data[$v->id]['id'] = $v->id;
            $data[$v->id]['code'] = $v->code;
            $data[$v->id]['parent_category_id'] = $v->parent_category_id;
            $data[$v->id]['category_name'] = $v->category_name;
            $data[$v->id]['category_name_display'] = $new_category[$v->id];
            $data[$v->id]['category_photo'] = $v->category_photo;
            $data[$v->id]['category_photo_display'] = empty($v->category_photo) ? _PATH_NO_IMAGE_ : _PATH_CATEGORY_ . $v->category_photo;
            $data[$v->id]['status'] = (int) $v->status;
        }

        return array_values($data);
    }

    public static function get_id_by_code($code)
    {
        $categories = Model_Category::find('all', array('where' => array(array('code', '=', $code))));
        foreach ($categories as $category) {
            return $category->id;
        }

        return false;
    }

    public static function get_id_by_parent_id($parent_category_id)
    {
        $data = array();
        $categories = Model_Category::find('all', array('where' => array(array('parent_category_id', '=', $parent_category_id))));
        foreach ($categories as $category) {
            $data[] = $category->id;
        }

        return $data;
    }

    public static function get_all_child_category_id($category_id)
    {
        $data = array();
        if (self::valid_field('id', $category_id)) {
            $ids = self::get_id_by_parent_id($category_id);
            $data = array_merge(array($category_id), $ids);
            while (!empty($ids)) {
                foreach ($ids as $k => $id) {
                    if ($k === 0) {
                        $ids = array();
                    }
                    $ids = array_merge($ids, self::get_id_by_parent_id($id));
                }
                $data = array_merge($data, $ids);
            }
        }

        return $data;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_Category::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

    public static function valid_by($where = array())
    {
        $result = Model_Category::query()->where($where);
        return ($result->count() > 0);
    }

}
