<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $guarded = [];

    public $timestamps = true;

    public function getImageAttribute($value)
    {
        return Storage::url('employees/' . $value);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function nation()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function phone(){
        return $this->belongsTo(Country::class, 'phone_code');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'role_post');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'employee_id', 'id');
    }
}
