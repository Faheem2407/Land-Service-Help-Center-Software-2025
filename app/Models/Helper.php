<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    protected $fillable = ['name'];

    public function receivers()
    {
        return $this->hasMany(Receiver::class);
    }
}
