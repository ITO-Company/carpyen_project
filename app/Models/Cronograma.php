<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronograma extends Model
{
    use HasFactory;

    protected $table = 'cronogramas';

    protected $fillable = [
        'fecha_inicio',
        'fecha_final',
        'dias_estimados',
        'estado',
        'id_proyecto',
        'user_id',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_final' => 'date',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_cronograma');
    }
}
