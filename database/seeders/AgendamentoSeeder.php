<?php

namespace Database\Seeders;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Servico;
use Illuminate\Database\Seeder;

class AgendamentoSeeder extends Seeder
{
    public function run(): void
    {
        // Precisa de pets e serviços já criados
        if (Pet::count() === 0 || Servico::count() === 0) {
            return;
        }

        Agendamento::factory()->count(25)->create();
    }
}
