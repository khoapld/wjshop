<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_Category extends Model_Migrate_Migratebase
{

    public static $_table_name = 'category';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'code' => ['constraint' => 50, 'type' => 'varchar'],
            'parent_category_id' => ['constraint' => 11, 'type' => 'int', 'default' => 0],
            'category_name' => ['type' => 'text'],
            'category_photo' => ['constraint' => 50, 'type' => 'varchar', 'null' => true],
            'level' => ['type' => 'int', 'constraint' => 4, 'default' => 0],
            'rank' => ['type' => 'int', 'constraint' => 4, 'null' => true],
            'status' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 2],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'code', 'code');
        DBUtil::create_index(self::$_table_name, 'parent_category_id', 'parent_category_id');
        DBUtil::create_index(self::$_table_name, 'level', 'level');
        DBUtil::create_index(self::$_table_name, 'status', 'status');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
