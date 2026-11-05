<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Pet;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Agendamento>
 */
class AgendamentoFactory extends Factory
{
    public function definition(): array
    {
        $dataHora = fake()->dateTimeBetween('-30 days', '+30 days');

        // Datas passadas viram concluído/cancelado; futuras ficam agendadas
        $status = $dataHora < now()
            ? fake()->randomElement(['concluido', 'concluido', 'cancelado'])
            : 'agendado';

        return [
            'id_pet' => Pet::inRandomOrder()->value('id') ?? Pet::factory(),
            'id_servico' => Servico::inRandomOrder()->value('id') ?? Servico::factory(),
            'data_hora' => $dataHora->format('Y-m-d H:i:00'),
            'status' => $status,
            'observacoes' => fake()->boolean(30) ? fake()->sentence(5) : null,
        ];
    }
}
