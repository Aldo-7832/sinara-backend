<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recolectado extends Model
{
    use HasFactory;

    protected $table = "recolectados";

    protected $fillable = [
        "id",
        "cantidad",
        "caducidad",
        "estatus",
        "producto_id",
        "donacion_id"
    ];

    public $timestamps = false;

    public function producto(){
        return $this->belongsTo(producto::class, "producto_id", "id");
    }

    public function donacion(){
        return $this->belongsTo(donacion::class, "donacion_id", "id");
    }

}
