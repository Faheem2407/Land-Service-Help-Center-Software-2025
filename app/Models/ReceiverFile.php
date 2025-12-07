<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiverFile extends Model
{
    protected $fillable = ['receiver_id', 'file_path'];

    public function receiver()
    {
        return $this->belongsTo(Receiver::class);
    }
}
