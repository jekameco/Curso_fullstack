<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    //relacion uno a muchos
    public function post(){
        return $this->hasMany('App\Post');
    }
}
