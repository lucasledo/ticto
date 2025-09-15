<?php

namespace App\Services;

use App\Contracts\RoleInterface;
use App\Models\Address;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserPersonService
{
    public function create(array $data, Role $role): Person
    {
        return DB::transaction(function() use ($data, $role) {

            $user = User::create([
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'role_id'       => optional($role)->id,
            ]);

            $person = Person::create([
                'name'          => $data['name'],
                'cpf'           => $data['cpf'],
                'position'      => $data['position'],
                'birthdate'     => $data['birthdate'],
                'user_id'       => $user->id,
            ]);

            Address::create([
                'addressable_type'  => Person::class,
                'addressable_id'    => $person->id,
                'cep'               => $data['cep'],
                'street'            => $data['street'],
                'number'            => $data['number'],
                'complement'        => $data['complement'] ?? null,
                'neighborhood'      => $data['neighborhood'],
                'city'              => $data['city'],
                'state'             => $data['state'],
            ]);

            return $person;
        });
    }

    public function update(RoleInterface $roleInterface,array $data): RoleInterface
    {
        return DB::transaction(function() use ($roleInterface, $data) {

            $roleInterface->person->user->fill($data)->update();

            $roleInterface->person->fill($data)->update();

            $roleInterface->person->address->fill($data)->update();

            return $roleInterface;
        });
    }

    public function delete(RoleInterface $roleInterface): RoleInterface
    {
        return DB::transaction(function() use ($roleInterface) {
            $roleInterface->person->address->delete();
            $roleInterface->person->delete();
            $roleInterface->person->user->delete();
            return $roleInterface;
        });
    }
}
