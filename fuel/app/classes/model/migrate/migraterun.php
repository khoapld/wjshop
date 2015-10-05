<?php

use Fuel\Core\Model;

class Model_Migrate_MigrateRun extends Model
{

    public static function all_up()
    {
        Model_Migrate_Category::up();
//        Model_Migrate_Order::up();
//        Model_Migrate_OrderItem::up();
        Model_Migrate_Photo::up();
        Model_Migrate_Product::up();
        Model_Migrate_ProductCategory::up();
        Model_Migrate_ProductPrice::up();
        Model_Migrate_User::up();
//        Model_Migrate_UserType::up();
    }

    public static function all_down()
    {
        Model_Migrate_Category::down();
//        Model_Migrate_Order::down();
//        Model_Migrate_OrderItem::down();
        Model_Migrate_Photo::down();
        Model_Migrate_Product::down();
        Model_Migrate_ProductCategory::down();
        Model_Migrate_ProductPrice::down();
        Model_Migrate_User::down();
//        Model_Migrate_UserType::down();
    }

    public static function all_nice()
    {
        Model_Migrate_User::add_user();
    }

}