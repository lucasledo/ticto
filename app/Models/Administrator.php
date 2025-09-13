<?php

namespace App\Models;

use App\Contracts\RoleInterface;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model implements RoleInterface
{
    protected $fillable = ['person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
