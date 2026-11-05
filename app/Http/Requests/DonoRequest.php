<?php

namespace App\Http\Requests;

use App\Services\Operations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DonoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    private function isCriacao(): bool
    {
        return $this->routeIs('newDonoSubmit');
    }

    // Na edição, o id do dono vem criptografado no campo hidden "dono_id"
    private function donoId()
    {
        if ($this->isCriacao()) {
            return null;
        }

        return Operations::tryDecryptId($this->input('dono_id'));
    }

    // Formata o CPF (000.000.000-00) antes de validar
    protected function prepareForValidation(): void
    {
        $cpf = $this->input('cpf');

        $this->merge([
            'cpf' => $cpf ? $this->formatarCpf($cpf) : null,
        ]);
    }

    private function formatarCpf($cpf)
    {
        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpfLimpo) !== 11) {
            return $cpf;
        }

        return sprintf(
            '%s%s%s.%s%s%s.%s%s%s-%s%s',
            ...str_split($cpfLimpo)
        );
    }

    public function rules(): array
    {
        $id = $this->donoId();

        $rules = [
            'nome' => 'required|min:2|max:100',
            'email' => [
                'required',
                'email',
                'min:8',
                'max:100',
                Rule::unique('donos', 'email')->ignore($id),
                // o e-mail do dono também é o login dele (tabela users)
                Rule::unique('users', 'email')->ignore($id, 'id_dono'),
            ],
            'telefone' => 'required|max:20',
            'cpf' => [
                'nullable',
                'min:11',
                'max:14',
                Rule::unique('donos', 'cpf')->ignore($id),
            ],
            'endereco' => 'nullable|max:255',
        ];

        if (!$this->isCriacao()) {
            $rules['dono_id'] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'dono_id.required' => 'Dono não identificado.',
            'nome.required' => 'O campo nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'email.required' => 'O Email é obrigatório.',
            'email.email' => 'Email inválido.',
            'email.min' => 'Precisa ter no mínimo :min caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'telefone.required' => 'O campo telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo :max caracteres.',
            'cpf.max' => 'O CPF inválido.',
            'cpf.min' => 'O CPF inválido.',
            'cpf.unique' => 'Este CPF já está cadastrado para outro dono.',
            'endereco.max' => 'O endereço deve ter no máximo :max caracteres.',
        ];
    }
}
