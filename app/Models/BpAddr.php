<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BpAddr extends Model
{
    protected $table = 'bpaddr';

    protected $fillable = [
        'bp_id',
        'name',
        'address',
        'phone',
        'zipcode',
        'note',
        'isbilladdr',
        'isshipaddr',
        'created_by',
        'updated_by',
        'email',
    ];

    protected $casts = [
        'isbilladdr' => 'boolean',
        'isshipaddr' => 'boolean',
    ];

    public function businessPartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'bp_id', 'id');
    }
}
