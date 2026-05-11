<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachment';

    protected $fillable = [
        'reftype',
        'refid',
        'bucket',
        'objkey',
        'caption',
        'description',
        'created_by',
    ];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->created_at) {
                $model->created_at = $model->freshTimestamp();
            }
        });
    }
}
