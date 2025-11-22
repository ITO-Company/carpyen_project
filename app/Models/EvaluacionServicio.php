<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionServicio extends Model
{
    use HasFactory;

    protected $table = 'evaluacion_servicios';

    protected $fillable = [
        'comentarios',
        'id_proyecto',
        'calificacion_diseno',
        'calificacion_tela',
        'calificacion_instalacion',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }
}
