<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    'title',
    'description',
    'status',              // Asegúrate de que esté aquí
    'dificultad',          // Agregado para el Admin/Analista
    'comentario_escalado', // Agregado para el Técnico
    'user_id'
    ];

    // LA FUNCIÓN DEBE IR AQUÍ ADENTRO
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} // Esta es la llave que cierra la clase y debe ser la última del archivo