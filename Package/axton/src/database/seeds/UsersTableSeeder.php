<?php
namespace ROBOAMP\Axton\Commands\Seeds;
use Illuminate\Database\Seeder;
use ROBOAMP\Robocore;
use App\User;
use Faker;
class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run(){

        User::where('email','like',"Axton_%")->delete();
        $faker = Faker\Factory::create();
        $password=bcrypt('secret');

        $users=[
            ['name'=>$faker->name,'email'=>'Axton_'.$faker->email, 'avatar'=>$faker->numberBetween(1,8),'password'=>$password,'created_at'=>time(),'updated_at'=>time() ],
            ['name'=>$faker->name,'email'=>'Axton_'.$faker->email, 'avatar'=>$faker->numberBetween(1,8),'password'=>$password,'created_at'=>time(),'updated_at'=>time() ],
            ['name'=>$faker->name,'email'=>'Axton_'.$faker->email, 'avatar'=>$faker->numberBetween(1,8),'password'=>$password,'created_at'=>time(),'updated_at'=>time() ],
            ['name'=>$faker->name,'email'=>'Axton_'.$faker->email, 'avatar'=>$faker->numberBetween(1,8),'password'=>$password,'created_at'=>time(),'updated_at'=>time() ],
            ['name'=>$faker->name,'email'=>'Axton_'.$faker->email, 'avatar'=>$faker->numberBetween(1,8),'password'=>$password,'created_at'=>time(),'updated_at'=>time() ],
            ['name'=>$faker->name,'email'=>'Axton_'.$faker->email, 'avatar'=>$faker->numberBetween(1,8),'password'=>$password,'created_at'=>time(),'updated_at'=>time() ]


        ];

        foreach ($users as $item){
            $user=new User();
            $user->name=$item['name'];
            $user->email=$item['email'];
            $user->password=$item['password'];
            $user->avatar=$item['avatar'];
            $user->created_at=$item['created_at'];
            $user->updated_at=$item['updated_at'];
            $user->save();
        }



    }
}
