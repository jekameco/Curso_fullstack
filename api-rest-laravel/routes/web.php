<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PruebasController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('welcome');
});

/*
    parametro NO opcional {nombre}
    parametro opcional {nombre?}
*/
Route::get('/pruebas/{nombre}', function ($nombre) {
    $texto = "<h2>Texto desde una ruta: $nombre</h2>";
    return view('pruebas',array(
        'texto' => $texto
    ));
});

/*
    llamado directamente al controller
    [nombreController]@[nombreMetodo]
*/
// Route::get('/animales', 'PruebasController@index');
Route::get('/animales', [PruebasController::class, 'index']);

// RUTAS DE PRUEBA
Route::get('/test', [PruebasController::class, 'testOrm']);
Route::get('/post', [PostController::class, 'pruebas']);
Route::get('/category', [CategoryController::class, 'pruebas']);
Route::get('/user', [UserController::class, 'pruebas']);

// RUTAS CONTROLADOR USUARIO
Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
