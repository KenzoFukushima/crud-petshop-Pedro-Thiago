<?php

namespace App\Http\Requests;

use App\Services\Operations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private function isCriacao(): bool
    {
        return $this->routeIs('newServicoSubmit');
    }

    public function rules(): array
    {
        $id = $this->isCriacao()
            ? null
            : Operations::tryDecryptId($this->input('servico_id'));

        $rules = [
            'nome' => [
                'required',
                'min:2',
                'max:100',
                Rule::unique('servicos', 'nome')->whereNull('deleted_at')->ignore($id),
            ],
            'descricao' => 'nullable|max:255',
            'preco' => 'required|numeric|min:0|max:999999.99',
            'duracao_minutos' => 'required|integer|min:5|max:480',
        ];

        if (!$this->isCriacao()) {
            $rules['servico_id'] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'servico_id.required' => 'Serviço não identificado.',
            'nome.required' => 'O nome do serviço é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'nome.unique' => 'Já existe um serviço com este nome.',
            'descricao.max' => 'A descrição deve ter no máximo :max caracteres.',
            'preco.required' => 'O preço é obrigatório.',
            'preco.numeric' => 'O preço deve ser um número.',
            'preco.min' => 'O preço não pode ser negativo.',
            'preco.max' => 'O preço deve ser no máximo :max.',
            'duracao_minutos.required' => 'A duração é obrigatória.',
            'duracao_minutos.integer' => 'A duração deve ser um número inteiro de minutos.',
            'duracao_minutos.min' => 'A duração mínima é de :min minutos.',
            'duracao_minutos.max' => 'A duração máxima é de :max minutos.',
        ];
    }
}
