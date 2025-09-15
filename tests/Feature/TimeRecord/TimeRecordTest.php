<?php

namespace Tests\Feature\TimeRecord;

use App\Models\Administrator;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TimeRecordTest extends TestCase
{
   use RefreshDatabase;

    protected Employee $employee;
    protected Administrator $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin    = Administrator::factory()->create();
        $this->employee = Employee::factory()->create([
            'administrator_id' => $this->admin->id,
        ]);
    }

    public function test_employee_can_register_time_record()
    {
        $this->actingAs($this->employee->person->user, 'web');

        $response = $this->post(route('time-records.store'));

        $response->assertRedirect();

        $this->assertDatabaseHas('time_records', [
            'employee_id' => $this->employee->id,
        ]);
    }

}
