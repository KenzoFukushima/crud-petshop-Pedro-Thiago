<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Mesma classe para cadastro e edição: a rota diz qual é o caso
    private function isCriacao(): bool
    {
        return $this->routeIs('newPetSubmit');
    }

    public function rules(): array
    {
        $rules = [
            'nome' => 'required|min:2|max:100',
            'especie' => 'required|max:50',
            'raça' => 'nullable|max:100',
            'peso' => 'nullable|numeric|min:0|max:999.99',
            'idade' => 'nullable|date|before_or_equal:today',
        ];

        if ($this->isCriacao()) {
            $rules['id_dono'] = [
                'required',
                Rule::exists('donos', 'id')->whereNull('deleted_at'),
            ];
        } else {
            $rules['pet_id'] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'id_dono.required' => 'O dono é obrigatório.',
            'id_dono.exists' => 'O dono selecionado não existe.',
            'pet_id.required' => 'Pet não identificado.',
            'nome.required' => 'O nome do pet é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'especie.required' => 'A espécie é obrigatória.',
            'especie.max' => 'A espécie deve ter no máximo :max caracteres.',
            'raça.max' => 'A raça deve ter no máximo :max caracteres.',
            'peso.numeric' => 'O peso deve ser um número.',
            'peso.min' => 'O peso não pode ser negativo.',
            'peso.max' => 'O peso deve ser no máximo :max kg.',
            'idade.date' => 'A data deve ser válida.',
            'idade.before_or_equal' => 'A data de nascimento não pode ser futura.',
        ];
    }
}
