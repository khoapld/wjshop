<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_Config extends Model_Migrate_Migratebase
{

    public static $_table_name = 'config';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'maintenance' => ['constraint' => 1, 'type' => 'tinyint', 'default' => 0],
            'email' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'telephone' => ['constraint' => 12, 'type' => 'varchar', 'null' => true],
            'address' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'fb_url' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'shop_name' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'maintenance', 'maintenance');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

    public static function add_config()
    {
        $props = [
            'maintenance' => 1,
            'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
        ];
        $query = Model_Config::forge($props);
        $query->save();
    }

}
