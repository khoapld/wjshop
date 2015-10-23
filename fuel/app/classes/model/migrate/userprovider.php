<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_UserProvider extends Model_Migrate_Migratebase
{

    public static $_table_name = 'user_providers';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'parent_id' => ['constraint' => 11, 'type' => 'int'],
            'provider' => ['constraint' => 255, 'type' => 'varchar'],
            'uid' => ['constraint' => 50, 'type' => 'varchar'],
            'secret' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'access_token' => ['constraint' => 255, 'type' => 'varchar', 'default' => ''],
            'expires' => ['constraint' => 11, 'type' => 'int', 'default' => 0],
            'refresh_token' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'created_at' => ['constraint' => 11, 'type' => 'int', 'default' => 0]
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'parent_id', 'parent_id');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
