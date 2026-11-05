<?php

namespace Database\Seeders;

use App\Models\Servico;
use Illuminate\Database\Seeder;

class ServicoSeeder extends Seeder
{
    public function run(): void
    {
        $servicos = [
            ['nome' => 'Banho',                'descricao' => 'Banho com shampoo e secagem',          'preco' => 50.00,  'duracao_minutos' => 45],
            ['nome' => 'Tosa',                 'descricao' => 'Tosa higiênica ou na máquina',          'preco' => 60.00,  'duracao_minutos' => 60],
            ['nome' => 'Banho e Tosa',         'descricao' => 'Pacote completo de banho e tosa',       'preco' => 100.00, 'duracao_minutos' => 90],
            ['nome' => 'Consulta Veterinária', 'descricao' => 'Consulta clínica de rotina',            'preco' => 150.00, 'duracao_minutos' => 30],
            ['nome' => 'Vacinação',            'descricao' => 'Aplicação de vacina (valor da dose)',   'preco' => 90.00,  'duracao_minutos' => 15],
            ['nome' => 'Corte de Unhas',       'descricao' => 'Corte e lixamento das unhas',           'preco' => 25.00,  'duracao_minutos' => 15],
        ];

        foreach ($servicos as $servico) {
            Servico::factory()->create($servico);
        }
    }
}
