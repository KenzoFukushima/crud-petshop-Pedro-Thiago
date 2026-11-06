<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgendamentoDonoRequest extends FormRequest
{
    // Se a validação falhar, volta para o formulário de agendar
    protected $redirect = '/inicio#agendar';

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $idDono = session('user.id_dono');

        return [
            // só aceita pet que pertence ao dono logado
            'id_pet' => [
                'required',
                Rule::exists('pets', 'id')
                    ->where('id_dono', $idDono)
                    ->whereNull('deleted_at'),
            ],
            'id_servico' => [
                'required',
                Rule::exists('servicos', 'id')->whereNull('deleted_at'),
            ],
            'data_hora' => 'required|date|after:now',
            'observacoes' => 'nullable|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'id_pet.required' => 'Selecione o pet.',
            'id_pet.exists' => 'O pet selecionado não é válido.',
            'id_servico.required' => 'Selecione o serviço.',
            'id_servico.exists' => 'O serviço selecionado não existe.',
            'data_hora.required' => 'Informe a data e a hora.',
            'data_hora.date' => 'Data e hora inválidas.',
            'data_hora.after' => 'Escolha uma data e uma hora futuras.',
            'observacoes.max' => 'As observações devem ter no máximo :max caracteres.',
        ];
    }
}