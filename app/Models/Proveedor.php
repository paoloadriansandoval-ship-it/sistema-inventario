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
        'correo',
        'direccion',
    ];
    #Define la relación entre productos y proveedores
    public function productos()
    {
        return $this->hasMany(Producto::class, 'proveedor_id');
    }
    public function entradas()
    {
        return $this->hasMany(Entradas::class, 'proveedor_id');
    }
}
