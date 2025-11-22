<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = 'cotizacions';

    protected $fillable = [
        'tipo_metro',
        'costo_metro',
        'cantidad_metro',
        'costo_muebles',
        'total',
        'estado',
        'numero_muebles',
        'comentarios',
        'id_proyecto',
        'user_id',
    ];

    protected $casts = [
        'costo_metro' => 'decimal:2',
        'cantidad_metro' => 'decimal:2',
        'costo_muebles' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function disenos()
    {
        return $this->hasMany(Diseno::class, 'id_cotizacion');
    }
}
