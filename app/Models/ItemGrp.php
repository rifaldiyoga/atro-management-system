<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemGrp extends Model
{
    protected $table = 'itgrp';

    protected $fillable = [
        'code',
        'name',
        'level',
        'up_id',
        'itemtype_code',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
}
