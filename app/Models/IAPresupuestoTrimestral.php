<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAPresupuestoTrimestral extends Model
{
    protected $table = 'ia_presupuesto_trimestral';

    protected $primaryKey = 'idPresupuestoTrimestral';

    public $timestamps = true;

    protected $fillable = [
        'idBS',
        'anio',
        'programa_presupuestario_id',
        'idComponente',
        'componente_texto',
        'actividad_texto',
        'tipo_gasto',
        't1',
        't2',
        't3',
        't4'
    ];
}

