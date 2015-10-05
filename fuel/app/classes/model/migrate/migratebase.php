<?php

use Fuel\Core\DBUtil;
use Fuel\Core\Model;

class Model_Migrate_MigrateBase extends Model
{

    public static $_table_name = '';
    public static $_test_data = [];

    public static function down_run($table_name)
    {
        $table_exists = DBUtil::table_exists($table_name);
        if (!$table_exists) {
            return false;
        }
        DBUtil::drop_table($table_name);
    }

    protected function test_data_create($instance = null)
    {
        if (is_null($instance)) {
            return false;
        }
        foreach (self::$_test_data as $row) {
            $instance->set($row);
            $instance->save();
        }
    }

    protected function set_test_data($data)
    {
        self::$_test_data = $data;
    }

    public static function nice()
    {
        self::down();
        self::up();
        self::test();
    }

}
