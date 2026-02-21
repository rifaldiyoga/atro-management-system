<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    protected $table = 'itemsupplier';

    // Composite primary key — no auto-increment
    protected $primaryKey = null;
    public $incrementing = false;

    protected $fillable = [
        'item_id',
        'bp_id',
        'vitemcode',
        'leadtime',
        'delivetime',
        'esttime',
        'isdefault',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'item_id' => 'integer',
        'bp_id' => 'integer',
        'leadtime' => 'integer',
        'delivetime' => 'integer',
        'esttime' => 'integer',
        'isdefault' => 'boolean',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function businessPartner()
    {
        return $this->belongsTo(BusinessPartner::class, 'bp_id', 'id');
    }
}
