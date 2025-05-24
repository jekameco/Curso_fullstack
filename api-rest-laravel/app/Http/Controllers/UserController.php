<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Helpers\JwtAuth;

class UserController extends Controller
{
    public function pruebas(Request $request){
        return "accion de ruebas de user controller";
    }
    public function register(Request $request){
        //recoger los datos del usuario con post
        // $json = $request->input('json',null); // es la forma de recibir con x-www-form-urlencode
        $json = $request->all(); //forma de recibir con json

        // limpiar datos
        $params = array_map('trim',$json);

        //validar datos
        $validate = Validator::make($params,[
            'name'      => 'required|alpha',
            'surname'   => 'required|alpha',
            'email'     => 'required|email|unique:users', // comprueba en la bd de users si existe el correo
            'password'  => 'required',
        ]);

        if($validate->fails()){
            $data = array(
                'status'  => 'error',
                'code'    => 400,
                'message' => 'los datos enviados no son correctos',
                'error'   => $validate->errors()
            );
            return response()->json($data,$data['code']);
        }

        //cifrar contraseña
        $pwd = password_hash($params['password'], PASSWORD_BCRYPT,['cost' => 6]);

        try {
            //crear usuario
            $user = new User();
            $user->name     = $params['name'];
            $user->surname  = $params['surname'];
            $user->email    = $params['email'];
            $user->role     = 'ROLE_USER';
            $user->password = $pwd;

            // //guardar usuario
            $user->save();

            $data = array(
                'status'  => 'success',
                'code'    => 200,
                'message' => 'Se ha creado el usuario'
            );
        }  catch (\Exception $e) {
            $data = array(
                'status'  => 'error',
                'code'    => 500,
                'message' => 'Error al crear el usuario',
                'error'   => $e->getMessage(),
            );
        }

        return response()->json($data,$data['code']);
    }

    public function login(Request $request){

        $json = $request->all();
        // validar_datos
        $params = array_map('trim',$json);

        $validate = Validator::make($params,[
            'email'     => 'required|email', // comprueba en la bd de users si existe el correo
            'password'  => 'required',
        ]);
        
        if($validate->fails()){
            $data = array(
                'status'  => 'error',
                'code'    => 404,
                'message' => 'El usuario no se ha podido identificar',
                'error'   => $validate->errors()
            );
            return response()->json($data,$data['code']);
        }

        // devolver token o datos
        $jwtAuth = new JwtAuth();
        $data = $jwtAuth->signUp($json['email'], $json['password']);
        if(!empty($params->getToken)){
            $data = $jwtAuth->signUp($json['email'], $json['password'], true);
        }
        return response()->json($data,200);
    }

    public function update(Request $request){
        $token = $request->header('Authorization');
        $jwtAuth = new JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);

        if($checkToken){
            echo "<h1>correcto</h1>";
        }else{
            echo "<h1>NO correcto</h1>";
        }
    }
}
