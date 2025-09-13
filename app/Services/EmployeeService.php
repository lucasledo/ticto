<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    protected $userPersonService;

    public function __construct(UserPersonService $userPersonService)
    {
        $this->userPersonService = $userPersonService;
    }

    public function create(array $data, User $user): Employee
    {
        $person = $this->userPersonService->create($data, Role::where('role', 'Employee')->first());

        return DB::transaction(function() use ($data, $user, $person) {
            return Employee::create([
                'person_id'         => $person->id,
                'administrator_id'  => $user->person->administrator->id,
            ]);
        });
    }

    public function update(Employee $employee, array $data): Employee
    {
        return $this->userPersonService->update($employee, $data);
    }

    public function delete(Employee $employee)
    {
        $this->userPersonService->delete($employee);

        return DB::transaction(function() use ($employee) {
            return $employee->delete();
        });
    }
}
