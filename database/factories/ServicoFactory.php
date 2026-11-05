<?php

namespace Database\Factories;

use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Servico>
 */
class ServicoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->randomElement([
                'Banho',
                'Tosa',
                'Banho e Tosa',
                'Consulta Veterinária',
                'Vacinação',
                'Corte de Unhas',
                'Hotelzinho (diária)',
            ]),
            'descricao' => fake()->sentence(6),
            'preco' => fake()->randomFloat(2, 30, 250),
            'duracao_minutos' => fake()->randomElement([15, 30, 45, 60, 90]),
        ];
    }
}
