<?php

use Fuel\Core\DBUtil;
use Fuel\Core\Model;

class Model_Migrate_MigrateBase extends Model
{

    public static $_table_name = '';

    public static function down_run($table_name)
    {
        $table_exists = DBUtil::table_exists($table_name);
        if (!$table_exists) {
            return false;
        }
        DBUtil::drop_table($table_name);
    }

}
