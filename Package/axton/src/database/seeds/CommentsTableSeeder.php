<?php
namespace ROBOAMP\Axton\Commands\Seeds;
use App\User;
use Illuminate\Database\Seeder;
use ROBOAMP\Robocore;
use Faker;
use ROBOAMP\Axton\W_Comments as Comments;
class CommentsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run(){
        Robocore::truncate('w_comments');
        $faker = Faker\Factory::create();

        $users=User::where('email','like','Axton_%')->get();
        $limit=count($users);


        $comments_array=[
            ['user_id'=>$users[$faker->numberBetween(1,$limit)-1]->id,'comment'=>$faker->text(200), 'status_id'=>$faker->numberBetween(1,5),'created_at'=>time(),'updated_at'=>time() ],
            ['user_id'=>$users[$faker->numberBetween(1,$limit)-1]->id,'comment'=>$faker->text(200), 'status_id'=>$faker->numberBetween(1,5),'created_at'=>time(),'updated_at'=>time() ],
            ['user_id'=>$users[$faker->numberBetween(1,$limit)-1]->id,'comment'=>$faker->text(200), 'status_id'=>$faker->numberBetween(1,5),'created_at'=>time(),'updated_at'=>time() ],
            ['user_id'=>$users[$faker->numberBetween(1,$limit)-1]->id,'comment'=>$faker->text(200), 'status_id'=>$faker->numberBetween(1,5),'created_at'=>time(),'updated_at'=>time() ],
            ['user_id'=>$users[$faker->numberBetween(1,$limit)-1]->id,'comment'=>$faker->text(200), 'status_id'=>$faker->numberBetween(1,5),'created_at'=>time(),'updated_at'=>time() ],
            ['user_id'=>$users[$faker->numberBetween(1,$limit)-1]->id,'comment'=>$faker->text(200), 'status_id'=>$faker->numberBetween(1,5),'created_at'=>time(),'updated_at'=>time() ],


        ];

        foreach ($comments_array as $item){
            $comments=new Comments();
            $comments->user_id=$item['user_id'];
            $comments->comment=$item['comment'];
            $comments->status_id=$item['status_id'];
            $comments->created_at=$item['created_at'];
            $comments->updated_at=$item['updated_at'];
            $comments->save();
        }



    }
}
