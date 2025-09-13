<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Employee;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeService
{
public function createEmployee(array $data, User $user)
    {
        return DB::transaction(function() use ($data, $user) {

            $employeeUser = User::create([
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'role_id'       => optional(Role::where('role', 'Employee')->first())->id,
            ]);

            $person = Person::create([
                'name'          => $data['name'],
                'cpf'           => $data['cpf'],
                'position'      => $data['position'],
                'birthdate'     => $data['birthdate'],
                'user_id'       => $employeeUser->id,
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

            return Employee::create([
                'person_id'         => $person->id,
                'administrator_id'  => $user->person->administrator->id,
            ]);
        });
    }

    public function updateEmployee(Employee $employee, array $data)
    {
        return DB::transaction(function() use ($employee, $data) {

            $employee->person->user->update([
                'email'         => $data['email'],
            ]);

            $employee->person->update([
                'name'          => $data['name'],
                'cpf'           => $data['cpf'],
                'position'      => $data['position'],
                'birth_date'    => $data['birth_date'],
            ]);

            $employee->person->address->update([
                'cep'               => $data['cep'],
                'street'            => $data['street'],
                'number'            => $data['number'],
                'complement'        => $data['complement'] ?? null,
                'neighborhood'      => $data['neighborhood'],
                'city'              => $data['city'],
                'state'             => $data['state'],
            ]);

            return $employee;
        });
    }

    public function deleteEmployee(Employee $employee)
    {
        return DB::transaction(function() use ($employee) {
            $employee->person->address->delete();
            $employee->person->delete();
            $employee->person->user->delete();
            return $employee->delete();
        });
    }
}
