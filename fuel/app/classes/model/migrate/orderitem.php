<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_OrderItem extends Model_Migrate_Migratebase
{

    public static $_table_name = 'order_items';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'order_item_id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'order_id' => ['constraint' => 11, 'type' => 'int'],
            'product_id' => ['constraint' => 11, 'type' => 'int'],
            'product_price' => ['constraint' => 11, 'type' => 'int'],
            'quantity' => ['constraint' => 11, 'type' => 'int'],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')]
            ], ['order_item_id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'order_id', 'order_id');
        DBUtil::create_index(self::$_table_name, 'product_id', 'product_id');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
