<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reg extends Model
{
  use HasFactory;

  protected $table = 'reg';

  protected $fillable = [
    'code',
    'name',
    'value',
    'isvisible',
    'modul_code',
    'valeditor',
    'type',
    'note',
    'index',
  ];

  protected $casts = [
    'isvisible' => 'boolean',
    'index' => 'integer',
  ];
}
