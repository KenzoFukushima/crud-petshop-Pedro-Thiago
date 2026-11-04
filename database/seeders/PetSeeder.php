<?php

namespace Database\Seeders;

use App\Models\Dono;
use App\Models\Pet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dono::all()->each(function ($dono) {
            Pet::factory()->count(2)->create([
                'id_dono' => $dono->id,
            ]);
        });
    }
}
