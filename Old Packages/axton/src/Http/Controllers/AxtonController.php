<?php

namespace ROBOAMP\Axton\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use ROBOAMP\Axton\W_Comments;

class AxtonController extends Controller
{
    public function index(){


        $data['comments']=W_Comments::all();
        $obj=$data['comments'][0];
        //dd($data['comments'],$obj->user->name,$obj->status->name);

        return view('Axton::inverse.index',$data);
    }
    public function dashboard(){
        if(Auth::user()){
            dd('something');
        }else{
            dd(Auth::user());
        }
        return view('Axton::inverse.dashboard');
    }
}
