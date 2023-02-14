<?php
namespace database\seeds;

use database\seeds\customers\LocalWordpress;
use database\seeds\customers\MansfieldDental;
use database\seeds\customers\AmericanReceivable;
use database\seeds\customers\Coravana;
use database\seeds\customers\demo\ShockwaveInnovations;
use database\seeds\customers\LGNetworks;
use database\seeds\customers\Seeder_RedRaiderOutfitter;
use database\seeds\customers\NorthTarrantDentalCare;
use database\seeds\customers\NorthArlingtonDentalCare;
use database\seeds\customers\Seeder_PayneMitchel;
use database\seeds\customers\Signup;
class PagesDataSeeder
{
    public static function data(){
        $data['shockave']=new ShockwaveInnovations();

        $data['mansfield']=new MansfieldDental();
        $data['northTarrantDental']= new NorthTarrantDentalCare();
        $data['northArlingtonDental']= new NorthArlingtonDentalCare();
        $data['american']=new AmericanReceivable();
        $data['coravana']=new Coravana();
        $data['LGNetworks']=new LGNetworks();
        $data['signup']=new Signup();
        $data['RedRaiderOutfitter']=new Seeder_RedRaiderOutfitter();
        $data['PayneMitchel']=new Seeder_PayneMitchel();
        $data['localwordpress']=new LocalWordpress();

        return $data;

    }
}