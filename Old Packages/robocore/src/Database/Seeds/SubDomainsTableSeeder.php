<?php

use Illuminate\Database\Seeder;
use App\SubDomain;
use ROBOAMP\DB; as myDB;

class SubDomainsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {

        $table="subdomains";

        $now=new \Carbon\Carbon();
        myDB::truncate($table);

        $subdomains=[

            ['id'=>1,'subdomain'=>'amp.coravana.com','created_at'=>$now,'updated_at'=>$now],

        ];

        foreach ($subdomains as $item){
            $subDomainClass = new SubDomain();
            foreach ($item as $obj =>$val){
                $subDomainClass->$obj=$val;
            }
            $subDomainClass->save();

        };


    }
}
