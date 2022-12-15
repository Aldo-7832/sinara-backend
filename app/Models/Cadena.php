<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cadena extends Model
{
    use HasFactory;

    protected $table = "cadenas";

    protected $fillable = [
        "id",
        "nombre",
        "descripcion",
        "estatus",
        "ubicacion_id"
    ];

    public $timestamps = false;
    
    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class, "ubicacion_id", "id");
    }

}
