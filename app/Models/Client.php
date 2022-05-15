<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $guarded = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'phone_code');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'product', 'id');
    }

    public function recordedRevenue()
    {
        return $this->hasOne(RecordedRevenue::class, 'client_id', 'id');
    }
}
