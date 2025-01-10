<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IAPoblacionGeneral extends Model
{
    public $timestamps = false;
    protected $table = "ia_poblacion_general";
    protected $fillable = [
        "ia_presupuesto_general_id",
        "tipo_poblacion_id",
        "tipo_poblacion_otro",
        "descripcion_poblacion",
        "poblacion_total",
        "poblacion_mujeres",
        "poblacion_hombres",
        "impacto_esperado",
        "descripcion_impacto"
    ];
}
