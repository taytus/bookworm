<?php

use Illuminate\Database\Seeder;
use ROBOAMP\MyArray;
use App\NotificationsType;
class NotificationsTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $types=[
                ['name'=>'User has not added a property'],
                ['name'=>'ROBOAMP code was cannot be found'],
                ['name'=>'User has not confirmed the code']
            ];
        MyArray::create_items_from_array('App\NotificationsType',$types);

    }
}
