<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name',
        'birthdate',
        'cpf',
        'position',
        'user_id',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function administrator()
    {
        return $this->hasOne(Administrator::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
