<?php

namespace ROBOAMP\Axton;

use Illuminate\Database\Eloquent\Model;

class W_Comments extends Model{

    protected $table='w_comments';

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function status(){
        return $this->belongsTo('ROBOAMP\Axton\W_Status','status_id','id');
    }
}
