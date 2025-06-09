<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoSector extends Model
{
   

    protected $table = 'productosector';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    protected $fillable = [
        'claveProducto',
        'producto',
        'idEstrategia',
        'estado_producto',
        'idDependencia',
    ];
}