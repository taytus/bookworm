<?php

namespace ROBOAMP\Axton;

use Illuminate\Console\Command;

use ROBOAMP\Axton\Commands\Seeds\DatabaseSeeder;

class Seeder extends Command
{
    protected $signature = 'Axton:migrate';

    protected $description = 'Migrate and seeds all the tables for Axton';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        //$this->call('composer dump-autoload');
        $this->call('migrate',['--path'=>'vendor/ROBOAMP/Axton/src/Database/migrations/']);
        $this->call('db:seed',['--class'=>'ROBOAMP\Axton\Commands\Seeds\DatabaseSeeder']);

    }

}
