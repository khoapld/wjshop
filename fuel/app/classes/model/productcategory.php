<?php

use Orm\Model;
use Fuel\Core\DB;
use Fuel\Core\Log;

class Model_ProductCategory extends Model
{

    protected static $_table_name = 'product_categories';
    protected static $_primary_key = array('product_id', 'category_id');
    protected static $_properties = array('product_id', 'category_id');

    public static function insert($props)
    {
        try {
            $query = DB::insert(static::$_table_name)->columns(static::$_properties);
            foreach ($props as $prop) {
                $query->values($prop);
            }
            if ($query->execute()) {
                return true;
            }
        } catch (Exception $e) {
            Log::write('ERROR', $e->getMessage());
            return false;
        }

        return false;
    }

}
