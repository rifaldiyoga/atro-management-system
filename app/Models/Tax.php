<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $table = 'tax';

    // Primary key is 'code' (varchar), not auto-increment
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'code',
        'name',
        'expr',
        'active',
        'created_by',
        'updated_by',
        'isdefault',
        'calcdpp',
    ];

    protected $casts = [
        'active' => 'boolean',
        'isdefault' => 'boolean',
    ];
}
