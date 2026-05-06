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

    /**
     * The "booted" method of the model.
     *
     * This method is called when the model is bootstrapped.
     * We use the 'creating' event to generate the code before saving a new record.
     */
    protected static function booted()
    {
        static::creating(function ($itemGrp) {
            // Check if code is already set to avoid overwriting it
            if (empty($itemGrp->code) || $itemGrp->code === 'AUTO') {
                $itemGrp->code = static::generateCode();
            }
        });
    }

    /**
     * Generate a unique, incrementing code.
     * Format: 000000001, 000000002, etc.
     *
     * @return string
     */
    public static function generateCode(): string
    {
        // Find the item with the highest ID to determine the next number.
        $lastItem = self::orderBy('id', 'desc')->first();

        $nextNumber = 1; // Default to 1 if no items exist yet.

        if ($lastItem) {
            $nextNumber = $lastItem->id + 1;
        }

        return str_pad($nextNumber, 9, '0', STR_PAD_LEFT);
    }
}
