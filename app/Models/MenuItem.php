<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'icon',
        'route',
        'href',
        'parent_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relación: Un menú puede tener muchos submenús
     */
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('order');
    }

    /**
     * Relación: Un submenú pertenece a un menú padre
     */
    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    /**
     * Scope para obtener solo los menús principales (sin padre)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id')->where('is_active', true)->orderBy('order');
    }

    /**
     * Scope para obtener solo menús activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
