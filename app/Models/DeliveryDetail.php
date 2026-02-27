<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryDetail extends Model
{
  protected $table = 'delid';

  protected $fillable = [
    'deli_id',
    'sod_id',
    'dno',
    'item_id',
    'itemname',
    'qty',
    'qtydeli',
    'unit',
    'conv',
    'qtyx',
    'cost',
    'baseprice',
    'listprice',
    'discexp',
    'discamt',
    'totaldiscamt',
    'disc2amt',
    'totaldisc2amt',
    'subtotal',
    'basesubtotal',
    'wh_id',
    'dnote',
    'tax_code',
    'taxableamt',
    'taxamt',
    'totaltaxamt',
    'basetotaltaxamt',
    'basefistotaltaxamt',
    'basetotaltaxamt4',
    'basefistotaltaxamt4',
  ];

  protected $casts = [
    'dno'                 => 'integer',
    'qty'                 => 'decimal:4',
    'qtydeli'             => 'decimal:4',
    'conv'                => 'decimal:4',
    'qtyx'                => 'decimal:4',
    'cost'                => 'decimal:4',
    'baseprice'           => 'decimal:4',
    'listprice'           => 'decimal:4',
    'discamt'             => 'decimal:4',
    'totaldiscamt'        => 'decimal:4',
    'disc2amt'            => 'decimal:4',
    'totaldisc2amt'       => 'decimal:4',
    'subtotal'            => 'decimal:4',
    'basesubtotal'        => 'decimal:4',
    'taxableamt'          => 'decimal:4',
    'taxamt'              => 'decimal:4',
    'totaltaxamt'         => 'decimal:4',
    'basetotaltaxamt'     => 'decimal:4',
    'basefistotaltaxamt'  => 'decimal:4',
    'basetotaltaxamt4'    => 'decimal:4',
    'basefistotaltaxamt4' => 'decimal:4',
  ];

  public function delivery()
  {
    return $this->belongsTo(Delivery::class, 'deli_id', 'id');
  }

  public function item()
  {
    return $this->belongsTo(Item::class, 'item_id', 'id');
  }

  public function salesOrderDetail()
  {
    return $this->belongsTo(SalesOrderDetail::class, 'sod_id', 'id');
  }
}
