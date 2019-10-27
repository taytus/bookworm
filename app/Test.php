<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model{

    protected $table="latest_tested";
    public $timestamps=false;

    public function deleteUntil($id){
        $this::where('id','<',$id)->delete();
    }

}
