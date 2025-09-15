<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Employee $employee) {
            if ($employee->person_id) {
                return;
            }

            $user = User::factory()->create([
                'role_id' => Role::firstOrCreate(['role' => 'Employee'])->id,
            ]);

            $employee->person_id = $user->person->id;
        });
    }
}
