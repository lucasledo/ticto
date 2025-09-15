<?php

namespace Database\Factories;

use App\Models\Administrator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrator>
 */
class AdministratorFactory extends Factory
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
        return $this->afterMaking(function (Administrator $administrator) {
            if ($administrator->person_id) {
                return;
            }

            $user = User::factory()->create([
                'role_id' => Role::firstOrCreate(['role' => 'Administrator'])->id,
            ]);

            $administrator->person_id = $user->person->id;
        });
    }
}
