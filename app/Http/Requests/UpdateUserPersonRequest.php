<?php

namespace App\Http\Requests;

use App\Contracts\RoleInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserPersonRequest extends FormRequest
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
        foreach($this->route()->parameters() as $param){
            if($param instanceof RoleInterface){
                $personId = $param->person->id;
                $userId   = $param->person->user->id;
            }
        }

        return [
            'name'          => 'sometimes|string|max:255',
            'cpf'           => 'sometimes|cpf|string|size:11|unique:people,cpf,' . $personId,
            'email'         => 'sometimes|email|unique:users,email,' . $userId,
            'position'      => 'sometimes|string|max:255',
            'birthdate'     => 'sometimes|date',
            'cep'           => 'sometimes|string|max:9',
            'street'        => 'sometimes|string|max:255',
            'number'        => 'sometimes|string|max:10',
            'complement'    => 'nullable|string|max:255',
            'neighborhood'  => 'sometimes|string|max:255',
            'city'          => 'sometimes|string|max:255',
            'state'         => 'sometimes|string|max:2',
        ];
    }

     public function messages(): array
    {
        return [
            'name.sometimes'         => 'O nome é obrigatório.',
            'email.sometimes'        => 'O email é obrigatório.',
            'email.email'           => 'Informe um email válido.',
            'email.unique'          => 'Este email já está em uso.',
            'cpf.sometimes'          => 'O CPF é obrigatório.',
            'cpf.cpf'               => 'Informe um CPF válido.',
            'cpf.unique'            => 'Este CPF já está cadastrado.',
            'birth_date.sometimes'   => 'A data de nascimento é obrigatória.',
            'cep.sometimes'          => 'O CEP é obrigatório.',
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
