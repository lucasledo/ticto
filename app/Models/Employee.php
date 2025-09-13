<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
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
}
