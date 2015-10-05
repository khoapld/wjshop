<?php

namespace Fuel\Tasks;

use Fuel\Core\Fuel;
use Fuel\Core\Cli;

class Migrations
{

    public static $_table_names = [];
    public static $msg = 'DB Migration Complete!!. - ';

    public static function run()
    {
        return Cli::color('
			this task is "WJ Shop project All tables Migration!!"

			php oil r migrations:up - create table
			php oil r migrations:down - drop table
			php oil r migrations:nice - drop and create after insert test_data
			', 'green');
    }

    public static function up()
    {
        \Model_Migrate_MigrateRun::all_up();
        return Cli::color(self::$msg . 'up - Table create', 'green');
    }

    public static function down()
    {
        \Model_Migrate_MigrateRun::all_down();
        return Cli::color(self::$msg . 'down - Table drop', 'red');
    }

    public static function nice()
    {
        if (Fuel::$env === Fuel::PRODUCTION) {
            return Cli::color('ENV = PRODUCTION can not use nice.', 'red');
        }
        \Model_Migrate_MigrateRun::all_down();
        \Model_Migrate_MigrateRun::all_up();
        \Model_Migrate_MigrateRun::all_nice();

        return Cli::color(self::$msg . 'nice - Table create & insert test data', 'green');
    }

}
