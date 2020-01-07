<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    //pongo en el array todos los campos de la tabla que lugo van a recibir valores
    protected $fillable = [
        'idcategoria', 'codigo', 'nombre', 'precio_venta', 'stock', 'descripcion', 'condicion'
    ];

    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
