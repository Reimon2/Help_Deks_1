<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['user_id', 'name', 'last_name', 'subject', 'priority', 'department', 'description'];

    // LA FUNCIÓN DEBE IR AQUÍ ADENTRO
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} // Esta es la llave que cierra la clase y debe ser la última del archivo