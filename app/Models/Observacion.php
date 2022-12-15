<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = "observaciones";

    protected $fillable = [
        "id",
        "observacion",
        "evidencia",
        "fecha",
        "recolectado_id"
    ];

    public $timestamps = false;

    public function recolectado(){
        return $this->belongsTo(Recolectado::class, "recolectado_id", "id");
    }

}
