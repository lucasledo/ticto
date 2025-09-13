<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $personId = $this->route('employee')->person->id ?? null;
        $userId   = $this->route('employee')->person->user->id ?? null;

        return [
            'name'          => 'required|string|max:255',
            'cpf'           => 'required|cpf|string|size:11|unique:people,cpf,' . $personId,
            'email'         => 'required|email|unique:users,email,' . $userId,
            'position'      => 'required|string|max:255',
            'birthdate'     => 'required|date',
            'cep'           => 'required|string|max:9',
            'street'        => 'required|string|max:255',
            'number'        => 'required|string|max:10',
            'complement'    => 'nullable|string|max:255',
            'neighborhood'  => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'state'         => 'required|string|max:2',
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
