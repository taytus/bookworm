<?php
namespace ROBOAMP\Axton\Commands\Seeds;
use Illuminate\Database\Seeder;
use ROBOAMP\Axton\W_Status as Status;
use ROBOAMP\ROBOCORE;
use ROBOAMP\MyArray;

class StatusTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run(){
        $model='\ROBOAMP\Axton\W_Status';
        $data=[
                ['name'=>'Approved','style'=>'badge-success'],
                ['name'=>'Rejected','style'=>'badge-danger'],
                ['name'=>'Reviewing','style'=>'badge-info'],
                ['name'=>'Finished','style'=>'badge-success'],
                ['name'=>'Pending','style'=>'badge-warning']
            ];
        MyArray::create_items_from_array($model,$data);


        ROBOCORE::truncate('w_status');

        MyArray::create_items_from_array($model,$data);



    }
}
