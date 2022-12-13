<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = "personas";

    protected $fillable = [
        "id",
        "nombre",
        "primer_apellido",
        "segundo_apellido",
        "fecha_nacimiento",
        "telefono",
        "fecha_registro",
        "ubicacion_id"
    ];

    public $timestamps = false;

    public function ubicacion(){
        return $this->belongsTo(Ubicacion::class, "ubicacion_id", "id");
    }
}
