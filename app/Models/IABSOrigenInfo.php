<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IABSOrigenInfo extends Model
{
    protected $table = 'ia_bs_origen_info';

    protected $fillable = [
        'idBS',
        'anio',
        'origen_informacion'
    ];
}
