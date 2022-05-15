<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedRevenue extends Model
{
    use HasFactory;

    protected $table = 'recorded_revenues';

    protected $guarded = [];

    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function revenue()
    {
        return $this->belongsTo(Revenue::class, 'revenue_id');
    }
}
