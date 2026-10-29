<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salidas extends Model
{
    protected $table = 'salidas';
    #Define campos
    protected $fillable = [
        'stock',
        'producto_id',
    ];
    #Define relaciones
        public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
