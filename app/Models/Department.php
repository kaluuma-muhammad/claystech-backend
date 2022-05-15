<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $guarded = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function head()
    {
        return $this->belongsTo(User::class, 'head_of_depart');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'phone_code');
    }

    public function employee()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }
}
