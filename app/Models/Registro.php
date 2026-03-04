<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    use HasFactory;

    protected $table = 'registros';
    protected $primaryKey = 'idRegistro';
    public $timestamps = true;
    protected $casts = [
        'activo' => 'boolean',
    ];

    protected $fillable = [
        'idDependencia',
        'user_id',
        'nombre',
        'cargo',
        'email',
        'telefono',
        'perfil',
        'tipo_enlace',
        'qr_uuid',
        'activo'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
