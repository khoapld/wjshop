<?php

use Fuel\Core\Log;
use Fuel\Core\Date;

class Model_Base_GroupFb
{

    public static function insert($data)
    {
        try {
            $props = [
                'group_id' => $data['group_id'],
                'group_name' => $data['group_name'],
                'privacy' => $data['privacy'],
                'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
            ];

            $new = Model_GroupFb::forge($props);
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
            $query = Model_GroupFb::find($id);
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
            $query = Model_GroupFb::find($id);
            $query->delete();
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return true;
    }

    public static function get_all($offset = _DEFAULT_OFFSET_, $limit = _DEFAULT_LIMIT_)
    {
        $data = Model_GroupFb::find('all', array(
                'order_by' => array('id' => 'desc'),
            //    'offset' => $offset,
            //    'limit' => $limit
        ));

        return self::map_data($data);
    }

    public static function count_all()
    {
        return Model_GroupFb::query()->count();
    }

    public static function get_by($option = array())
    {
        try {
            $data = Model_GroupFb::find('all', array(
                    'select' => !empty($option['select']) ? $option['select'] : array(),
                    'where' => !empty($option['where']) ? $option['where'] : array(),
                    'order_by' => !empty($option['order_by']) ? $option['order_by'] : array('id' => 'desc'),
                    'offset' => !empty($option['offset']) ? $option['offset'] : _DEFAULT_OFFSET_,
                    'limit' => !empty($option['limit']) ? $option['limit'] : _DEFAULT_LIMIT_
            ));
            return self::map_data($data);
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
        $query = Model_GroupFb::query()->select($select)->where($where)->order_by($order_by);
        return $query->count();
    }

    public static function get_one($id, $option = array())
    {
        try {
            $data = Model_GroupFb::find('all', array(
                    'select' => !empty($option['all']) ? $option['select'] : array(),
                    'where' => !empty($option['where']) ? array_merge(array(array('id' => $id)), $option['where']) : array('id' => $id),
                    'order_by' => !empty($option['order_by']) ? $option['order_by'] : array('id' => 'desc')
            ));
            return self::map_data($data)[$id];
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
        }

        return false;
    }

    public static function map_data($group)
    {
        $data = array();
        foreach ($group as $v) {
            $data[$v->id]['id'] = $v->id;
            $data[$v->id]['group_id'] = $v->group_id;
            $data[$v->id]['group_name'] = $v->group_name;
            $data[$v->id]['privacy'] = $v->privacy;
        }
        return $data;
    }

    public static function valid_field($field, $val)
    {
        $result = Model_GroupFb::query()->where(array($field => $val));
        return ($result->count() > 0);
    }

}
