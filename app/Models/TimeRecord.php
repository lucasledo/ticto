<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeRecord extends Model
{
    protected $fillable = [
        'employee_id',
        'time_recorded_at',
        'ip',
        'user_agent'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
