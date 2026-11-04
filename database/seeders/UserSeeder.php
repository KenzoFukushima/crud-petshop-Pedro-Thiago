<?php

namespace Database\Seeders;

use App\Models\Dono;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // admin
        User::factory()->admin()->create([
            'username' => 'admin',
            'email' => 'admin@petshop.com',
        ]);

        // um login para cada dono
        Dono::all()->each(function ($dono) {
            User::factory()->create([
                'username' => $dono->email,
                'email' => $dono->email,
                'role' => 'dono',
                'id_dono' => $dono->id,
            ]);
        });
    }
}