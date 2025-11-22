<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diseno extends Model
{
    use HasFactory;

    protected $table = 'disenos';

    protected $fillable = [
        'url_render',
        'plano_laminado',
        'aprobado',
        'fecha_aprobacion',
        'comentario',
        'id_cotizacion',
        'user_id',
    ];

    protected $casts = [
        'fecha_aprobacion' => 'date',
        'aprobado' => 'boolean',
    ];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizacion');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
