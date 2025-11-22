<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorProducto extends Model
{
    use HasFactory;

    protected $table = 'proveedor_productos';

    protected $fillable = [
        'cantidad',
        'precio_unitario',
        'total',
        'id_proveedor',
        'id_producto',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
