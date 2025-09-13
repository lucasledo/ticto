<?php

namespace App\Models;

use App\Contracts\RoleInterface;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model implements RoleInterface
{
    protected $fillable = ['person_id', 'administrator_id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function administrator()
    {
        return $this->belongsTo(Administrator::class);
    }

    public function timeRecords()
    {
        return $this->hasMany(TimeRecord::class);
    }
}
