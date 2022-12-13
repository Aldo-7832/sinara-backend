<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    use HasFactory;

    protected $table = "donaciones";

    protected $fillable = [
        "id",
        "folio",
        "estatus",
        "fecha_recoleccion",
        "observaciones_generales",
        "cadena_id",
        "usuario_id"
    ];

    public $timestamps = false;

    public function cadena(){
        return $this->belongsTo(Cadena::class, "cadena_id", "id");
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class, "usuario_id", "id");
    }
}
