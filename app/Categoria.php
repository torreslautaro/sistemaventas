<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    // protected $table = 'categorias'; se lo usa en caso de que la tabla tenga otro nombre
    // protected $primaryKey = 'id'; laravel por defecto entiende que la clave primaria es el campo id que se definio en las migraciones, por lo tanto, no es necesario usar esta sentencia, salvo que, el campo primarykey sea otro 

    protected $fillable = ['nombre','descripcion','condicion'];

    public function articulos(){
        return $this->hasMany('App\Articulo');
    }
}
