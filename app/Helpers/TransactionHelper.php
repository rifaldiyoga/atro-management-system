<?php

namespace App\Helpers;

class TransactionHelper
{
  /**
   * Generate an auto-incrementing transaction number
   *
   * @param string $modelClass The fully qualified class name of the Eloquent model.
   * @param string $prefix The transaction prefix (e.g., 'SQ', 'SO').
   * @param string|null $trxdate The transaction date to determine the YM component.
   * @return string The generated transaction number.
   */
  public static function generateTrxNo($modelClass, $prefix, $trxdate = null)
  {
    $yM = $trxdate ? date('Ym', strtotime($trxdate)) : date('Ym');
    $fullPrefix = $prefix . '-' . $yM . '-';

    $lastRecord = $modelClass::where('trxno', 'like', $fullPrefix . '%')
      ->orderBy('trxno', 'desc')
      ->first();

    if ($lastRecord && preg_match('/-(\d{4})$/', $lastRecord->trxno, $matches)) {
      $newNumber = str_pad((int)$matches[1] + 1, 4, '0', STR_PAD_LEFT);
    } else {
      $newNumber = '0001';
    }

    return $fullPrefix . $newNumber;
  }
}
