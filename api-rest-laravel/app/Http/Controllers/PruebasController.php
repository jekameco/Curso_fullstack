<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Category;

class PruebasController extends Controller
{
    public function index(){
        $titulo = 'Animales';
        $animales = array('perro','gato','tigre');
        return view('pruebas.index', array(
            'titulo' => $titulo,
            'animales' => $animales
        ));
    }

    public function testOrm(){
        $posts = Post::all();
        foreach ($posts as $post) {
            echo "<h1>".$post->title."</h1>";
            echo "<h1>{$post->user->name} - {$post->category->name}</h1>";
            echo "<hr>";
            echo "<h2>".$post->content."</h2>";
            // var_dump($post);
            # code...
        }

        die();
    }
}
