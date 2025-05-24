<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class JwtAuth {
    private $key;
    
    public function __construct() {
        $this->key = 'ayduame-dios-por-favor1234135498798712313543';
    }

    public function signUp($email, $password, $getToken = null) {
        // buscar si existe usuario con credenciales
        $user = User::where([
            'email' => $email
        ])->first();
        
        // validar si son correctas
        $singUp = false;
        if(is_object($user)){
            $singUp = true;
        }
        
        //generar el token con los datos del usuario
        if($singUp && password_verify($password, $user->password)){
            $token = array(
                'sub'     => $user['id'],
                'email'   => $user['email'],
                'name'    => $user['name'],
                'surname' => $user['surname'],
                'iat'     => time(),
                'exp'     => time() +(7 * 24 * 60 * 60),
            );

            $jwt     = JWT::encode($token, $this->key, 'HS256');
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));

            if(is_null($getToken)){
                $data = $jwt;
            }else{
                $data =  $decoded;
            }
        }else{
            $data = array(
                'status' => 'error',
                'message' => 'Login incorrecto'
            );
        }

        return $data;
    }

    public function checkToken($jwt, $getIdentity = false) {
        $auth = false;

        try {
            $decoded = JWT::decode($jwt, new Key($this->key, 'HS256'));
        } catch (\UnexpectedValueException $e) {
            $auth = false;
        } catch (\DomainException $e) {
            $auth = false;
        } 

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        }

        if ($getIdentity) {
            return $decoded;
        }

        return $auth;
    }

    
}
