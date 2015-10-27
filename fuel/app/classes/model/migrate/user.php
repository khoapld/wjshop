<?php

use Fuel\Core\DB;
use Fuel\Core\DBUtil;
use Fuel\Core\Date;

class Model_Migrate_User extends Model_Migrate_Migratebase
{

    public static $_table_name = 'users';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'id' => ['constraint' => 11, 'type' => 'int', 'auto_increment' => true],
            'username' => ['constraint' => 32, 'type' => 'varchar'],
            'email' => ['constraint' => 255, 'type' => 'varchar'],
            'password' => ['constraint' => 255, 'type' => 'varchar'],
            'login_hash' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'last_login' => ['constraint' => 11, 'type' => 'int', 'default' => 0],
            'group' => ['constraint' => 11, 'type' => 'int', 'default' => 1],
            'password_code' => ['constraint' => 32, 'type' => 'varchar', 'null' => true],
            'full_name' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'gender' => ['constraint' => 1, 'type' => 'int', 'default' => 0],
            'birthday' => ['constraint' => 10, 'type' => 'varchar', 'null' => true],
            'address' => ['constraint' => 255, 'type' => 'varchar', 'null' => true],
            'telephone' => ['constraint' => 12, 'type' => 'varchar', 'null' => true],
            'user_photo' => ['constraint' => 50, 'type' => 'varchar', 'null' => true],
            'created_at' => ['type' => 'timestamp', 'default' => DB::expr('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'timestamp', 'default' => '0000-00-00 00:00:00']
            ], ['id'], true, 'InnoDB', 'utf8_general_ci'
        );

        DBUtil::create_index(self::$_table_name, 'username', 'username');
        DBUtil::create_index(self::$_table_name, 'email', 'email');
        DBUtil::create_index(self::$_table_name, 'password', 'password');
        DBUtil::create_index(self::$_table_name, 'login_hash', 'login_hash');
        DBUtil::create_index(self::$_table_name, 'group', 'group');
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

    public static function add_user()
    {
        $user_props = [
            'username' => 'wjshop',
            'email' => 'admin@wjshop.com',
            'password' => Model_Service_Util::hash_password('11111111'),
            'group' => 100,
            'customer_name' => 'wjshop',
            'created_at' => date('Y-m-d H:i:s', Date::forge()->get_timestamp())
        ];
        $user = Model_User::forge($user_props);
        $user->save();
    }

}
