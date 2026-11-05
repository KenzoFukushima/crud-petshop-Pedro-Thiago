<?php

namespace App\Http\Requests;

use App\Models\Agendamento;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AgendamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private function isCriacao(): bool
    {
        return $this->routeIs('newAgendamentoSubmit');
    }

    public function rules(): array
    {
        $rules = [
            'id_pet' => [
                'required',
                Rule::exists('pets', 'id')->whereNull('deleted_at'),
            ],
            'id_servico' => [
                'required',
                Rule::exists('servicos', 'id')->whereNull('deleted_at'),
            ],
            // novo agendamento não pode ser no passado; ao editar, permite
            // ajustar um agendamento antigo (ex.: marcar como concluído)
            'data_hora' => $this->isCriacao()
                ? 'required|date|after_or_equal:now'
                : 'required|date',
            'status' => ['required', Rule::in(Agendamento::STATUS)],
            'observacoes' => 'nullable|max:255',
        ];

        if (!$this->isCriacao()) {
            $rules['agendamento_id'] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'agendamento_id.required' => 'Agendamento não identificado.',
            'id_pet.required' => 'Selecione o pet.',
            'id_pet.exists' => 'O pet selecionado não existe.',
            'id_servico.required' => 'Selecione o serviço.',
            'id_servico.exists' => 'O serviço selecionado não existe.',
            'data_hora.required' => 'Informe a data e a hora.',
            'data_hora.date' => 'Data e hora inválidas.',
            'data_hora.after_or_equal' => 'A data e a hora não podem estar no passado.',
            'status.required' => 'Selecione o status.',
            'status.in' => 'Status inválido.',
            'observacoes.max' => 'As observações devem ter no máximo :max caracteres.',
        ];
    }
}
