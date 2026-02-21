<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPartner extends Model
{
    use HasFactory;

    protected $table = 'bp';

    protected $fillable = [
        'code',
        'name',
        'version',
        'bankname',
        'bankaccno',
        'bankaccname',
        'email',
        'website',
        'note',
        'active',
        'created_by',
        'updated_by',
        'cmpname',
        'bptype',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Auto-generate code on creating if not provided.
     */
    protected static function booted()
    {
        static::creating(function ($businessPartner) {
            if (empty($businessPartner->code) || $businessPartner->code === 'AUTO') {
                $businessPartner->code = static::generateCode();
            }
        });
    }

    /**
     * Generate a unique, incrementing code.
     * Format: 00001, 00002, etc.
     */
    public static function generateCode(): string
    {
        $lastPartner = self::orderBy('code', 'desc')->first();

        $nextNumber = 1;

        if ($lastPartner && is_numeric($lastPartner->code)) {
            $nextNumber = intval($lastPartner->code) + 1;
        }

        return str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function addresses()
    {
        return $this->hasMany(BpAddr::class, 'bp_id', 'id');
    }
}

