<?php

use Fuel\Core\DBUtil;

class Model_Migrate_ProductCategory extends Model_Migrate_Migratebase
{

    public static $_table_name = 'product_categories';

    public static function up()
    {
        $table_exists = DBUtil::table_exists(self::$_table_name);
        if ($table_exists) {
            return false;
        }

        DBUtil::create_table(
            self::$_table_name, [
            'category_id' => ['constraint' => 11, 'type' => 'int'],
            'product_id' => ['constraint' => 11, 'type' => 'int'],
            'rank' => ['constraint' => 11, 'type' => 'int', 'default' => 1]
            ], ['category_id', 'product_id'], true, 'InnoDB', 'utf8_general_ci'
        );
    }

    public static function down()
    {
        parent::down_run(self::$_table_name);
    }

}
