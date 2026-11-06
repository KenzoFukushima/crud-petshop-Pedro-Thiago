<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CadastroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
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
        return [
            'nome' => 'required|min:2|max:100',
            'email' => [
                'required',
                'email',
                'min:8',
                'max:100',
                Rule::unique('donos', 'email'),
                Rule::unique('users', 'email'),
            ],
            'telefone' => 'required|max:20',
            'cpf' => [
                'nullable',
                'min:11',
                'max:14',
                Rule::unique('donos', 'cpf'),
            ],
            'endereco' => 'nullable|max:255',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.min' => 'O nome deve ter no mínimo :min caracteres.',
            'nome.max' => 'O nome deve ter no máximo :max caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'E-mail inválido.',
            'email.min' => 'O e-mail deve ter no mínimo :min caracteres.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.max' => 'O telefone deve ter no máximo :max caracteres.',
            'cpf.min' => 'CPF inválido.',
            'cpf.max' => 'CPF inválido.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'endereco.max' => 'O endereço deve ter no máximo :max caracteres.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação não é igual à senha.',
        ];
    }
}