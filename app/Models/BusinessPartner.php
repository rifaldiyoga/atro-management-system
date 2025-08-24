<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessPartner extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'phone',
        'email',
        'photo_url',
        'partner_type',
        'description',
        'is_active',
        'address',
    ];

    /**
     * The "booted" method of the model.
     *
     * This method is called when the model is bootstrapped.
     * We use the 'creating' event to generate the code before saving a new record.
     */
    protected static function booted()
    {
        static::creating(function ($businessPartner) {
            // Check if code is already set to avoid overwriting it
            if (empty($businessPartner->code) || $businessPartner->code === 'AUTO') {
                $businessPartner->code = static::generateCode();
            }
        });
    }

    /**
     * Generate a unique, incrementing code.
     * Format: 000001, 000002, etc.
     *
     * @return string
     */
    public static function generateCode(): string
    {
        // Find the business partner with the highest numeric code
        $lastPartner = self::orderBy('code', 'desc')
            ->first();


        $nextNumber = 1; // Default to 1 if no partners exist yet.

        if ($lastPartner && is_numeric($lastPartner->code)) {
            $nextNumber = intval($lastPartner->code) + 1;
        }

        // Format the number with leading zeros to a total length of 6.
        return str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
