<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function post()
    {
        return $this->hasOne(Post::class, 'added_by', 'id');
    }

    public function department()
    {
        return $this->hasOne(Department::class, 'head_of_depart', 'id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'added_by', 'id');
    }

    public function revenue()
    {
        return $this->hasOne(Revenue::class, 'product', 'id');
    }

    public function recordedRevenue()
    {
        return $this->hasOne(RecordedRevenue::class, 'recorded_by', 'id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'head_of_project', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'area_code', 'id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'added_by', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'recorded_by', 'id');
    }

    public function expense()
    {
        return $this->hasOne(Expense::class, 'recorded_by', 'id');
    }
}
