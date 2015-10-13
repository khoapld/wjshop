<?php

use Fuel\Core\Log;
use Fuel\Core\Date;

class Model_Base_Category
{

    public static function insert($data)
    {
        try {
            $props = [
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

    public static function get_all()
    {
        $category = Model_Category::find('all', array(
                'select' => array('parent_category_id', 'category_name', 'category_photo', 'status'),
                'order_by' => array('rank' => 'asc')
        ));

        return self::map_category($category);
    }

    public static function get_parent($parent_category_id = null)
    {
        $data = array();
        $category = Model_Category::query()
                ->from_cache(false)
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
        foreach ($category as $k => $v) {
            $data[$v->id]['id'] = $v->id;
            $data[$v->id]['parent_category_id'] = $v->parent_category_id;
            $data[$v->id]['category_name'] = $v->category_name;
            $data[$v->id]['category_name_display'] = $new_category[$v->id];
            $data[$v->id]['category_photo'] = $v->category_photo;
            $data[$v->id]['category_photo_display'] = empty($v->category_photo) ? _PATH_NO_IMAGE_ : _PATH_CATEGORY_ . $v->category_photo;
            $data[$v->id]['status'] = (int) $v->status;
        }

        return $data;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_Category::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

}
