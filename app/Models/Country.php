<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    public function user()
    {
        return $this->hasMany(User::class, 'area_code', 'id');
    }

    public function employeeCountry()
    {
        return $this->hasOne(Employee::class, 'country_id', 'id');
    }

    public function employeePhone()
    {
        return $this->hasOne(Employee::class, 'phone_code', 'id');
    }
}
