<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedors';

    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'email',
        'direccion',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'proveedor_productos', 'id_proveedor', 'id_producto')
                    ->withPivot('cantidad', 'precio_unitario', 'total')
                    ->withTimestamps();
    }
}
