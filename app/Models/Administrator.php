<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
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
