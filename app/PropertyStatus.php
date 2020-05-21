<?php

namespace App;

use App\Partials\PartialTemplate;
use Illuminate\Database\Eloquent\Model;

class PropertyStatus extends Model
{
    //
    protected $table = "property_status";

    public function status(){
        return $this->belongsTo('App\Property');
    }



}

