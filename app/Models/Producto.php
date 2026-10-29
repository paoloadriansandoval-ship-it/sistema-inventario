<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    #Definimos nombre
    protected $table = 'productos';
    #Define campos
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'existencias',
        'stock_minimo',
        'proveedor_id',
    ];
    #Define relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id');
    }
    public function entradas()
    {
        return $this->hasMany(Entradas::class, 'producto_id');
    }
        public function salidas()
    {
        return $this->hasMany(Salidas::class, 'producto_id');
    }
}
