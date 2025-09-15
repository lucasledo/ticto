<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AddressService
{
    public static function fillAddressFromCep(array $data): array
    {
        if (!empty($data['cep']) && empty($data['street'])) {
            $cep = preg_replace('/\D/', '', $data['cep']);
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->ok() && !$response->json('erro')) {
                $viaCep = $response->json();

                $data['street']        = $viaCep['logradouro'] ?? '';
                $data['neighborhood']   = $viaCep['bairro'] ?? '';
                $data['city']           = $viaCep['localidade'] ?? '';
                $data['state']          = $viaCep['uf'] ?? '';
            }
        }

        return $data;
    }
}
