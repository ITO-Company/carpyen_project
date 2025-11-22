<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;

    protected $table = 'proyectos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'ubicacion',
        'estado',
        'id_cliente',
        'user_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_proyectos', 'id_proyecto', 'id_producto')
                    ->withPivot('cantidad', 'sobrante')
                    ->withTimestamps();
    }

    public function cotizaciones()
    {
        return $this->hasMany(Cotizacion::class, 'id_proyecto');
    }

    public function cronogramas()
    {
        return $this->hasMany(Cronograma::class, 'id_proyecto');
    }

    public function planPagos()
    {
        return $this->hasMany(PlanPago::class, 'id_proyecto');
    }

    public function evaluacionServicios()
    {
        return $this->hasMany(EvaluacionServicio::class, 'id_proyecto');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class, 'id_proyecto');
    }
}
