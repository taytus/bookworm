<?php

use Illuminate\Database\Seeder;
use App\MyClasses\Seeders;
use ROBOAMP\MyArray;
class NotifyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $notifications=[
            [
                'name'=>'First Reminder',
                'copy'=>json_encode([
                    'subject'=> 'Just a Couple More Steps!',
                    'greetings'=>'Hi {{username}},<br>',
                    'body'=>'Congrats on signing up! Please confirm that your code is in the right place by clicking {{ link }}.'
                ]),
                'interval'=>'3 days',
                'notifications_type_id'=>1

            ],
            [
                'name'=>'Second Reminder',
                'copy'=>json_encode([
                    'subject'=> 'reminder 2!',
                    'greetings'=>'Hey {{username}}!!!!,<br>',
                    'body'=>'blah blah.'
                ]),
                'interval'=>'4 days',
                'notifications_type_id'=>1

            ]


        ];

        MyArray::create_items_from_array('App\Notify',$notifications);



    }
}
