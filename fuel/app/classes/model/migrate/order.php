<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_Order extends Model_Migrate_Migratebase
{

    public static $_table_name = 'orders';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'order_id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'user_id' => ['constraint' => 11, 'type' => 'int'],
            'message' => ['type' => 'text', 'null' => true],
            'order_email' => ['type' => 'text', 'null' => true],
            'order_gender' => ['type' => 'text', 'null' => true],
            'order_last_name' => ['type' => 'text', 'null' => true],
            'order_first_name' => ['type' => 'text', 'null' => true],
            'order_last_name_kana' => ['type' => 'text', 'null' => true],
            'order_first_name_kana' => ['type' => 'text', 'null' => true],
            'order_tel' => ['type' => 'text', 'null' => true],
            'order_fax' => ['type' => 'text', 'null' => true],
            'order_zip' => ['type' => 'text', 'null' => true],
            'order_addr' => ['type' => 'text', 'null' => true],
            'payment_total' => ['constraint' => 11, 'type' => 'int'],
            'payment_method' => ['constraint' => 1, 'type' => 'int'],
            'payment_status' => ['constraint' => 1, 'type' => 'int', 'default' => 1],
            'payment_date' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00'],
            'del_flg' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 0],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['order_id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'user_id', 'user_id');
        DBUtil::create_index(self::$_table_name, 'payment_method', 'payment_method');
        DBUtil::create_index(self::$_table_name, 'payment_status', 'payment_status');
        DBUtil::create_index(self::$_table_name, 'del_flg', 'del_flg');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
