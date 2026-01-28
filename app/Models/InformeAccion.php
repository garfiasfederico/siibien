<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformeAccion extends Model
{
    protected $table ="informe_acciones";
    protected $fillable = [
        "nombre",
        "idDependencia",
        "idTemaPED",
        "alineacion_la",
        "ae_cuadros",
        "orden",
        "creacion",
        "parrafos_max",
        "objetivo",
        "descripcion",
        "cobertura",
        //"p_entrega",
        //"p_otro",
        "anio_inicio",
        "estado",
        "tipo",
        "r_o",
        "prioritario",
        "vigente",
        "anio",
    ];

    protected static function booted()
    {
        static::creating(function ($model) {

            //Fecha de corte
            $diaCorte = 1;
            $mesCorte = 3;

            $hoy = Carbon::now();
            $fechaCorte = Carbon::create($hoy->year, $mesCorte, $diaCorte);

            if ($hoy->greaterThanOrEqualTo($fechaCorte)) {
                $model->anio = $hoy->year;
            } else {
                $model->anio = $hoy->year - 1;
            }
        });
    }
}
