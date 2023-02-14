<?php

use Illuminate\Database\Seeder;

class MasterTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $table=DB::table('master_templates')->truncate();
        //sections=> 1=footer, 2=social following
        $dataset=[];
        $now=\Carbon\Carbon::now();

        $dataset[]=['sections_id'=>json_encode([1,2]),'name'=>'Scenic','path'=>'scenic','uuid'=>$this->uuid(),'created_at'=>$now,'updated_at'=>$now];
       // $dataset[]=['sections_id'=>json_encode([1,2]),'name'=>'Article','path'=>'article','uuid'=>$this->uuid(),'created_at'=>$now,'updated_at'=>$now];
        $dataset[]=['sections_id'=>json_encode([1]),'name'=>'Article','path'=>'article','uuid'=>$this->uuid(),'created_at'=>$now,'updated_at'=>$now];
        $dataset[]=['sections_id'=>json_encode([2]),'name'=>'Beck&Galo','path'=>'beckandgalo','uuid'=>$this->uuid(),'created_at'=>$now,'updated_at'=>$now];
       // $dataset[]=['sections_id'=>json_encode([]),'name'=>'Galo','path'=>'beckandgalo','uuid'=>$this->uuid(),'created_at'=>$now,'updated_at'=>$now];

        DB::table('master_templates')->insert($dataset);




    }

    private function uuid(){
        return bin2hex(openssl_random_pseudo_bytes(8));
    }
}
