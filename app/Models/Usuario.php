<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        "id",
        "activo",
        "contrasenia",
        "usuario",
        "rol_id",
        "persona_id",
        "updated_at",
        "created_at"
    ];

    protected $hidden = [
        'contrasenia', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol(){
        return $this->belongsTo(Rol::class, "rol_id", "id");
    }
    
    public function persona(){
        return $this->belongsTo(Persona::class, "persona_id", "id");
    }

}
