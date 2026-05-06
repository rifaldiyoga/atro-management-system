<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\TransactionHelper;
use App\Models\SaleDetail;

class Sale extends Model
{
  protected $table = 'sale';

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
    'dpamt',
    'ship_id',
    'valid_days',
    'ship_eta',
    'pay_due_period',
    'due_date',
    'reserved_var1',
    'reserved_var2',
    'reserved_var3',
    'reserved_int1',
    'reserved_int2',
    'reserved_int3',
    'reserved_num1',
    'reserved_num2',
    'reserved_num3',
    'isautogen',
    'reqdtime',
    'note_emp',
    'attn',
  ];

  protected $casts = [
    'trxdate'      => 'datetime',
    'due_date'     => 'datetime',
    'reqdtime'     => 'datetime',
    'isdraft'      => 'boolean',
    'isvoid'       => 'boolean',
    'active'       => 'boolean',
    'taxed'        => 'boolean',
    'taxinc'       => 'boolean',
    'isautogen'    => 'boolean',
    'subtotal'     => 'decimal:4',
    'basesubtotal' => 'decimal:4',
    'discamt'      => 'decimal:4',
    'basediscamt'  => 'decimal:4',
    'taxamt'       => 'decimal:4',
    'basetaxamt'   => 'decimal:4',
    'basefistaxamt' => 'decimal:4',
    'total'        => 'decimal:4',
    'basetotal'    => 'decimal:4',
    'dpamt'        => 'decimal:4',
    'reserved_num1' => 'decimal:4',
    'reserved_num2' => 'decimal:4',
    'reserved_num3' => 'decimal:4',
  ];

  protected static function booted()
  {
    static::saving(function ($model) {
      if (empty($model->trxno) || $model->trxno === 'AUTO') {
        $model->trxno = TransactionHelper::generateTrxNo(static::class, 'SALE', $model->trxdate);
      }
    });
  }

  public function details()
  {
    return $this->hasMany(SaleDetail::class, 'sale_id', 'id');
  }

  public function bp()
  {
    return $this->belongsTo(BusinessPartner::class, 'bp_id', 'id');
  }

  public function srep()
  {
    return $this->belongsTo(Salesman::class, 'srep_id', 'id');
  }

  public function salesOrder()
  {
    return $this->belongsTo(SalesOrder::class, 'refid', 'id');
  }
}
