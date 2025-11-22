<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoProyecto extends Model
{
    use HasFactory;

    protected $table = 'producto_proyectos';

    protected $fillable = [
        'cantidad',
        'sobrante',
        'id_proyecto',
        'id_producto',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'id_proyecto');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
