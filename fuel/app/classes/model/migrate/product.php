<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_Product extends Model_Migrate_Migratebase
{

    public static $_table_name = 'products';

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
            'product_name' => ['type' => 'text'],
            'product_description' => ['type' => 'text', 'null' => true],
            'product_info' => ['type' => 'text', 'null' => true],
            'note' => ['type' => 'text', 'null' => true],
            'product_photo' => ['constraint' => 50, 'type' => 'varchar', 'null' => true],
            'status' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 2],
            'highlight' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 0],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'code', 'code');
        DBUtil::create_index(self::$_table_name, 'status', 'status');
        DBUtil::create_index(self::$_table_name, 'highlight', 'highlight');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
