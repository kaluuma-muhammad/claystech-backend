<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $guarded = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function head()
    {
        return $this->belongsTo(User::class, 'head_of_project');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'product', 'id');
    }

    public function revenue()
    {
        return $this->hasOne(Revenue::class, 'product', 'id');
    }
}
