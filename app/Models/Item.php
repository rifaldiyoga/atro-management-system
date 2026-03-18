<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
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
        'taxcode',
        'unit',
        'price',
        'discexp',
        'lastpurcprice',
        'description',
        'itemtype',
        'active',
        'photo_url',
    ];

    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
        'lastpurcprice' => 'decimal:2',
    ];

    /**
     * The "booted" method of the model.
     *
     * This method is called when the model is bootstrapped.
     * We use the 'creating' event to generate the code before saving a new record.
     */
    protected static function booted()
    {
        static::creating(function ($item) {
            // Check if code is already set to avoid overwriting it
            if (empty($item->code)) {
                $item->code = static::generateCode();
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
            // We get the last ID and increment it. This is a reliable way
            // to get the next number in the sequence.
            $nextNumber = $lastItem->id + 1;
        }

        // Format the number with leading zeros to a total length of 9.
        return str_pad($nextNumber, 9, '0', STR_PAD_LEFT);
    }

    public function salesOrderDetails()
    {
        return $this->hasMany(SalesOrderDetail::class, 'item_id');
    }

    public function salesQuotationDetails()
    {
        return $this->hasMany(SalesQuotationDetail::class, 'item_id');
    }

    public function suppliers()
    {
        return $this->hasMany(ItemSupplier::class, 'item_id');
    }
}
