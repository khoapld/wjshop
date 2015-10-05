<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_ProductPrice extends Model_Migrate_Migratebase
{

    public static $_table_name = 'product_prices';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'product_id' => ['constraint' => 11, 'type' => 'int'],
            'price' => ['constraint' => 11, 'type' => 'int', 'default' => 0],
            'del_flg' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 0],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'product_id', 'product_id');
        DBUtil::create_index(self::$_table_name, 'del_flg', 'del_flg');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
