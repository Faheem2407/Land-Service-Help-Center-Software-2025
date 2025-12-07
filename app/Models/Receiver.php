<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receiver extends Model
{
    protected $fillable = [
        'date',
        'si_no',
        'receipt_no',
        'category_id',
        'receiver_name',
        'mobile',
        'village',
        'account_book_no',
        'district_id',
        'sub_district_id',
        'nid_no',
        'tracking_no',
        'helper_id',
        'processing_charge',
        'online_charge',
        'total_charge'
    ];

    /* Relationships */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function helper()
    {
        return $this->belongsTo(Helper::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function subDistrict()
    {
        return $this->belongsTo(SubDistrict::class);
    }

    public function files()
    {
        return $this->hasMany(ReceiverFile::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
