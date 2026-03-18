<?php

namespace App\Helpers;

class TransactionHelper
{
  /**
   * Generate an auto-incrementing transaction number.
   *
   * Format: {sequence}/AIG/{prefix}/{month}/{year}
   * Example: 439/AIG/PO/12/2025
   *
   * @param string      $modelClass The fully qualified Eloquent model class name.
   * @param string      $prefix     The document type prefix (e.g. 'PO', 'SO', 'SQ').
   * @param string|null $trxdate    The transaction date to derive month/year from.
   * @return string
   */
  public static function generateTrxNo($modelClass, $prefix, $trxdate = null)
  {
    $date  = $trxdate ? strtotime($trxdate) : time();
    $month = (int) date('m', $date);   // e.g. 12
    $year  = (int) date('Y', $date);   // e.g. 2025

    // Fixed suffix: AIG/{prefix}/{month}/{year}
    $suffix = 'AIG/' . $prefix . '/' . $month . '/' . $year;

    // Find the last record with this suffix and extract its sequence number
    $lastRecord = $modelClass::where('trxno', 'like', '%/' . $suffix)
      ->orderByRaw("CAST(SPLIT_PART(trxno, '/', 1) AS INTEGER) DESC")
      ->first();

    if ($lastRecord && preg_match('/^(\d+)\//', $lastRecord->trxno, $matches)) {
      $newNumber = (int) $matches[1] + 1;
    } else {
      $newNumber = 1;
    }

    return $newNumber . '/' . $suffix;
  }
}
