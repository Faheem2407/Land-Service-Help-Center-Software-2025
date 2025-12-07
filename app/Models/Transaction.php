<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'receiver_id',
        'type',
        'amount',
    ];

    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }
}
