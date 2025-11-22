<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
    ];

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'id_cliente');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_cliente');
    }
}
