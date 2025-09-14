<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birthdate
                ? $this->birthdate->age
                : null
        );
    }

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
