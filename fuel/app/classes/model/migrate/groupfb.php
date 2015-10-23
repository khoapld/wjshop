<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;

class Model_Migrate_GroupFb extends Model_Migrate_Migratebase
{

    public static $_table_name = 'group_fb';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'group_id' => ['constraint' => 50, 'type' => 'varchar'],
            'group_name' => ['constraint' => 50, 'type' => 'varchar'],
            'privacy' => ['constraint' => 255, 'type' => 'varchar'],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'group_id', 'group_id');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
