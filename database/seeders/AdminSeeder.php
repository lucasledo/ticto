<?php

namespace Database\Seeders;

use App\Models\Administrator;
use App\Models\Person;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::where('email', 'admin@ticto.com')->exists()) {
            return;
        }

        $user = User::create([
            'email'     => 'admin@ticto.com',
            'password'  => Hash::make('admin123'),
        ]);

        $person = Person::create([
            'name'      => 'Administrador Padrão',
            'user_id'   => $user->id,
            'cpf'       => '00000000000',
            'birthdate' => '1990-01-01',
            'position'  => 'Dev',
        ]);

        Administrator::create([
            'person_id' => $person->id,
        ]);
    }
}
