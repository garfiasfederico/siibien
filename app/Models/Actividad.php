<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';

    protected $primaryKey = 'idActividad';

    public $timestamps = false;

    protected $fillable = [
        'idComponente',
        'claveActividad',
        'descripcionActividad'
    ];
}