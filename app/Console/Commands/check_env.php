<?php

namespace App\Console\Commands;
use ROBOAMP\Commands\EnvCommand;
use Illuminate\Console\Command;
use ROBOAMP\Server;

class check_env extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prints out ENV vars to check if everything is OK';


    public function handle(){


        $this->call(EnvCommand::class);
    }

}
