<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAPresupuestoTrimestralActividad extends Model
{
    protected $table = 'ia_presupuesto_trimestral_actividad';

    public $incrementing = false; 

    protected $fillable = [
        'idPresupuestoTrimestral',
        'idActividad'
    ];
}