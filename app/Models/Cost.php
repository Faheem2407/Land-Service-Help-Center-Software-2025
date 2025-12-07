<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    protected $fillable = [
        'date', 
        'cost_source_id', 
        'description', 
        'amount'
    ];

    public function source()
    {
        return $this->belongsTo(CostSource::class, 'cost_source_id');
    }
}
