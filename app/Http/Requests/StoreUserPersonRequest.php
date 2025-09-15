<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserPersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'name'          => 'required|string|max:255',
                'cpf'           => 'required|cpf|string|max:14|unique:people,cpf',
                'email'         => 'required|email|max:255|unique:users,email',
                'position'      => 'required|string|max:255',
                'birthdate'     => 'required|date',
                'cep'           => 'required|string|max:9',
                'street'        => 'sometimes|string|max:255',
                'number'        => 'sometimes|string|max:10',
                'complement'    => 'nullable|string|max:255',
                'neighborhood'  => 'sometimes|string|max:255',
                'city'          => 'sometimes|string|max:255',
                'state'         => 'sometimes|string|max:2',
                'password'      => 'required|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'O nome é obrigatório.',
            'email.required'        => 'O email é obrigatório.',
            'email.email'           => 'Informe um email válido.',
            'email.unique'          => 'Este email já está em uso.',
            'cpf.required'          => 'O CPF é obrigatório.',
            'cpf.cpf'               => 'Informe um CPF válido.',
            'cpf.unique'            => 'Este CPF já está cadastrado.',
            'birth_date.required'   => 'A data de nascimento é obrigatória.',
            'cep.required'          => 'O CEP é obrigatório.',
            'cep.size'              => 'O CEP deve ter 8 dígitos numéricos.',
        ];
    }

    /**
     * Limpar campos antes da validação.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => preg_replace('/\D/', '', $this->cpf),
            'cep' => preg_replace('/\D/', '', $this->cep),
        ]);
    }
}
