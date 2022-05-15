<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;

    protected $table = 'revenues';

    protected $guarded = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'product');
    }

    public function recordedRevenue()
    {
        return $this->hasOne(RecordedRevenue::class, 'revenue_id', 'id');
    }
}
