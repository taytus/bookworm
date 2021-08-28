<?php
/**
 * Created by PhpStorm.
 * User: taytus
 * Date: 9/21/18
 * Time: 10:16 AM
 */

namespace App\MyClasses;

use App\Console\Commands\Stripe;
use Symfony\Component\Process\Process;
class Runner {

    public function Run($command){
        dd($command);
    }
    public function Stripe_menu(){

        $this->call('ROBOAMP:Stripe', [
        ]);

       dd("end");
        $str = "php artisan ROBOAMP:Stripe";
        system('clear');
        $command= new Stripe();
        $command->handle();
        /*
        $process = new Process($str);
        $process->disableOutput();
        $process->run();
        */

    }

} 