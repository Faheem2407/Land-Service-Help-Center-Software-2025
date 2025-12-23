<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'module', 'actions'];

    protected $casts = [
        'actions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
