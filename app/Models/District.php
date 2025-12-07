<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function subDistricts()
    {
        return $this->hasMany(SubDistrict::class);
    }

    public function receivers()
    {
        return $this->hasMany(Receiver::class);
    }
}
