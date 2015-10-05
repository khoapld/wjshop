<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_UserType extends Model_Migrate_Migratebase
{

    public static $_table_name = 'user_types';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'type_id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'type_name' => ['type' => 'text'],
            'type_description' => ['type' => 'text', 'null' => true],
            'del_flg' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 0],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['type_id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'del_flg', 'del_flg');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
