<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesQuotation extends Model
{
    protected $table = 'sq';

    protected $fillable = [
        'trxno',
        'trxdate',
        'branch_id',
        'bp_id',
        'reftype',
        'refid',
        'trxtype',
        'version',
        'isdraft',
        'isvoid',
        'status',
        'note',
        'active',
        'created_by',
        'updated_by',
        'taxed',
        'taxinc',
        'billaddr',
        'shipaddr',
        'srep_id',
        'subtotal',
        'basesubtotal',
        'discexp',
        'discamt',
        'basediscamt',
        'taxamt',
        'basetaxamt',
        'basefistaxamt',
        'total',
        'basetotal',
        'reserved_var1',
        'reserved_var2',
        'reserved_var3',
        'reserved_int1',
        'reserved_int2',
        'reserved_int3',
        'reserved_num1',
        'reserved_num2',
        'reserved_num3',
        'note_emp',
    ];

    protected $casts = [
        'trxdate' => 'datetime',
        'isdraft' => 'boolean',
        'isvoid' => 'boolean',
        'active' => 'boolean',
        'taxed' => 'boolean',
        'taxinc' => 'boolean',
        'subtotal' => 'decimal:4',
        'basesubtotal' => 'decimal:4',
        'discamt' => 'decimal:4',
        'basediscamt' => 'decimal:4',
        'taxamt' => 'decimal:4',
        'basetaxamt' => 'decimal:4',
        'basefistaxamt' => 'decimal:4',
        'total' => 'decimal:4',
        'basetotal' => 'decimal:4',
        'reserved_num1' => 'decimal:4',
        'reserved_num2' => 'decimal:4',
        'reserved_num3' => 'decimal:4',
    ];

    public function details()
    {
        return $this->hasMany(SalesQuotationDetail::class, 'sq_id', 'id');
    }

    public function bp()
    {
        return $this->belongsTo(BusinessPartner::class, 'bp_id', 'id');
    }
}
