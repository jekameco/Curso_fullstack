<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "accion de ruebas de user controller";
    }
    public function register(Request $request){
        $name = $request->input('name');
        $surname = $request->input('surname');
        return 'ayuda mundo '.$name.$surname;
    }
    public function login(Request $request){
        return 'ayuda mundo';
    }
}
