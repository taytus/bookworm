<?php

namespace ROBOAMP\Commands;

use Illuminate\Console\Command;
use ROBOAMP\Files;

class SeederCommand extends Command
{
    protected $signature = 'Seeder:Install';

    protected $description = 'This command overwrite the stub for new migrations';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $files_class=new Files();
        $file_name="blank.stub";
        $origin=dirname(__DIR__, 1)."/".$file_name;
        $destination=base_path('vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/blank.stub');
        $files_class->copy_file($origin,$destination);

        $destination=base_path('vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/create.stub');
        $files_class->copy_file($origin,$destination);

        $destination=base_path('vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/update.stub');
        $files_class->copy_file($origin,$destination);

        echo "\nMigration Files have been updated\n";
    }

}
