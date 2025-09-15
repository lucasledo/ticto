<?php

namespace Tests\Feature\Employee;

use App\Models\Administrator;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Administrator::factory()->create()->person->user;

        Role::firstOrCreate(['role' => 'Employee']);
    }

    public function test_admin_can_create_employee()
    {
        $this->actingAs($this->admin, 'web');

        $response = $this->post(route('employees.store'), [
            'name'          => 'Arden Lopez',
            'cpf'           => '220.799.380-96',
            'email'         => 'pocatezuwi@mailinator.com',
            'position'      => 'Reprehenderit dolor',
            'birthdate'     => '1995-10-11',
            'cep'           => '14780-240',
            'street'        => 'Avenida 7',
            'number'        => '454',
            'complement'    => 'Debitis voluptate ul',
            'neighborhood'  => 'Fortaleza',
            'city'          => 'Barretos',
            'state'         => 'SP',
            'password'      => '123123123',
            'password_confirmation' => '123123123',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('people', ['name' => 'Arden Lopez']);
    }

    public function test_admin_can_update_employee()
    {
        $this->actingAs($this->admin, 'web');

        $employee = Employee::factory()->create([
            'administrator_id' => $this->admin->person->administrator->id,
        ]);

        $response = $this->put(route('employees.update', $employee), [
            'name'          => 'Updated Name'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('people', ['name' => 'Updated Name']);
    }

    public function test_admin_can_delete_employee()
    {
        $this->actingAs($this->admin);

        $employee = Employee::factory()->create([
            'administrator_id' => $this->admin->person->administrator->id,
        ]);

        $employee->load('person.user');

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertRedirect();
        $this->assertDatabaseMissing('people', ['id'    => $employee->person->id]);
        $this->assertDatabaseMissing('users', ['id'     => $employee->person->user->id]);
        $this->assertDatabaseMissing('employees', ['id' => $employee->id]);
    }

    public function test_cannot_create_employee_with_duplicate_cpf()
    {
        $this->actingAs($this->admin);

        $employee = Employee::factory()->create([
            'administrator_id' => $this->admin->person->administrator->id,
        ]);

        $response = $this->post(route('employees.store'), [
            'name'          => 'Arden Lopez',
            'cpf'           => $employee->person->cpf,
            'email'         => 'pocatezuwi@mailinator.com',
            'position'      => 'Reprehenderit dolor',
            'birthdate'     => '1995-10-11',
            'cep'           => '14780-240',
            'street'        => 'Avenida 7',
            'number'        => '454',
            'complement'    => 'Debitis voluptate ul',
            'neighborhood'  => 'Fortaleza',
            'city'          => 'Barretos',
            'state'         => 'SP',
            'password'      => '123123123',
            'password_confirmation' => '123123123',
        ]);

        $response->assertSessionHasErrors('cpf');
    }

}
