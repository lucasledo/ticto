<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => $this->faker->name(),
            'birthdate' => $this->faker->date(),
            'cpf'       => $this->faker->unique()->numerify('###########'),
            'position'  => $this->faker->jobTitle(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Person $person) {
            Address::factory()->create([
                'addressable_id'   => $person->id,
                'addressable_type' => Person::class,
            ]);
        });
    }
}
