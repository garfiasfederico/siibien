<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentePresupuestario extends Model
{
    protected $table = 'componente_presupuestario';

    protected $primaryKey = 'idComponente';

    public $timestamps = false;

    protected $fillable = [
        'idPrograma',
        'claveComponente',
        'descripcionComponente'
    ];
}