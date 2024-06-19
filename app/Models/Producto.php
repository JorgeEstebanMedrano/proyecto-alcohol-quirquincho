<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    //NOMBRE DE LA TABLA
    protected $table = 'Producto';

    //CAMPOS A LLENAR
    protected $fillable = [
        'id',
        'envase',
        'capacidad',
        'precio',
        'stock',
        'almacen_id'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id';
}
