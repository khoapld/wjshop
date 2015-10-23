<?php

use Fuel\Core\Model;

class Model_Migrate_MigrateRun extends Model
{

    public static function all_up()
    {
        Model_Migrate_Config::up();
        Model_Migrate_User::up();
        Model_Migrate_UserProvider::up();
        Model_Migrate_GroupFb::up();
        Model_Migrate_Category::up();
        Model_Migrate_Product::up();
        Model_Migrate_ProductCategory::up();
        Model_Migrate_Photo::up();
    }

    public static function all_down()
    {
        Model_Migrate_Config::down();
        Model_Migrate_User::down();
        Model_Migrate_UserProvider::down();
        Model_Migrate_GroupFb::down();
        Model_Migrate_Category::down();
        Model_Migrate_Product::down();
        Model_Migrate_ProductCategory::down();
        Model_Migrate_Photo::down();
    }

    public static function all_nice()
    {
        Model_Migrate_User::add_user();
        Model_Migrate_Config::add_config();
    }

}
