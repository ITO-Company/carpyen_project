<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tareas';

    protected $fillable = [
        'hora_inicio',
        'hora_final',
        'descripcion',
        'estado',
        'id_cronograma',
        'id_proyecto',
        'user_id',
    ];

    public function cronograma()
    {
        return $this->belongsTo(Cronograma::class, 'id_cronograma');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
