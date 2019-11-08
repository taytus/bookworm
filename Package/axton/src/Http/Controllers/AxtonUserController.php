<?php

namespace ROBOAMP\Axton\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AxtonUserController extends Controller
{
    public function index(){
        return view('Axton::inverse.login');
    }
    public function post_form(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials,true)) {
            return redirect()->route('dashboard');
        }

    }
}
