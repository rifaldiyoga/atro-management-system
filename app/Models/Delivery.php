<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\TransactionHelper;
use App\Models\DeliveryDetail;

class Delivery extends Model
{
  protected $table = 'deli';

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
    'billaddr',
    'shipaddr',
    'srep_id',
    'ship_id',
    'reqdtime',
    'shiptime',
    'note_emp',
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
  ];

  protected $casts = [
    'trxdate'      => 'datetime',
    'reqdtime'     => 'datetime',
    'shiptime'     => 'datetime',
    'isdraft'      => 'boolean',
    'isvoid'       => 'boolean',
    'active'       => 'boolean',
    'isautogen'    => 'boolean',
    'reserved_num1' => 'decimal:4',
    'reserved_num2' => 'decimal:4',
    'reserved_num3' => 'decimal:4',
  ];

  protected static function booted()
  {
    static::saving(function ($model) {
      if (empty($model->trxno) || $model->trxno === 'AUTO') {
        $model->trxno = TransactionHelper::generateTrxNo(static::class, 'DELI', $model->trxdate);
      }
    });
  }

  public function details()
  {
    return $this->hasMany(DeliveryDetail::class, 'deli_id', 'id');
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
