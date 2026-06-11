<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'José Admin',
            'email' => 'admin@helpdesk.com',
            'password' => Hash::make('12345678'),
            'role' => 'administrador',
        ]);

        // Técnico
        User::create([
            'name' => 'José Técnico',
            'email' => 'tecnico@helpdesk.com',
            'password' => Hash::make('12345678'),
            'role' => 'tecnico',
        ]);

        // Analista
        User::create([
            'name' => 'José Analista',
            'email' => 'analista@helpdesk.com',
            'password' => Hash::make('12345678'),
            'role' => 'analista',
        ]);
    }
}