<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesQuotation;
use App\Models\SalesQuotationDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesQuotationController extends Controller
{
  public function index()
  {
    $perPage = request()->query('per_page', 10);
    $search = request()->query('search');
    $sort = request()->query('sort', 'id');
    $direction = request()->query('direction', 'asc');
    $query = SalesQuotation::with('bp');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw('LOWER(trxno) LIKE ?', ['%' . strtolower($search) . '%']);
      });
    }

    $allowedSortFields = ['id', 'trxno', 'trxdate', 'status', 'total', 'created_at'];
    if (!in_array($sort, $allowedSortFields)) {
      $sort = 'id';
    }

    $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

    $records = $query->orderBy($sort, $direction)->paginate($perPage);

    return response()->json([
      'status' => 'success',
      'message' => 'Sales quotation list fetched successfully',
      'data' => $records->items(),
      'meta' => [
        'current_page' => $records->currentPage(),
        'last_page' => $records->lastPage(),
        'per_page' => $records->perPage(),
        'total' => $records->total(),
        'sort' => $sort,
        'direction' => $direction,
      ]
    ], 200);
  }

  public function show($id)
  {
    $record = SalesQuotation::with(['details', 'bp', 'srep'])->find($id);
    if (!$record) {
      return response()->json([
        'status' => 'error',
        'message' => 'Sales quotation not found',
        'data' => null
      ], 404);
    }

    return response()->json([
      'status' => 'success',
      'message' => 'Sales quotation fetched successfully',
      'data' => $record
    ], 200);
  }

  public function store(Request $request)
  {
    DB::beginTransaction();
    try {
      $data = $request->except('details');
      $data['created_by'] = auth()->id() ?? 1;
      $data['updated_by'] = auth()->id() ?? 1;
      if (!array_key_exists('version', $data)) {
        $data['version'] = 1;
      }
      if (empty($data['billaddr']) && isset($data['shipaddr'])) {
        $data['billaddr'] = $data['shipaddr'];
      }
      $details = $request->input('details', []);

      $record = SalesQuotation::create($data);

      Log::info($details);

      foreach ($details as $detail) {
        $detail['sq_id'] = $record->id;
        SalesQuotationDetail::create($detail);
      }

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'Sales quotation created successfully',
        'data' => $record->load('details')
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => 'Failed to create sales quotation',
        'data' => null,
        'error' => $e->getMessage()
      ], 400);
    }
  }

  public function update(Request $request, $id)
  {
    $record = SalesQuotation::find($id);
    if (!$record) {
      return response()->json([
        'status' => 'error',
        'message' => 'Sales quotation not found',
        'data' => null
      ], 404);
    }

    DB::beginTransaction();
    try {
      $data = $request->except('details');
      $data['updated_by'] = auth()->id() ?? 1;
      $data['version'] = $record->version + 1;
      if (empty($data['billaddr']) && isset($data['shipaddr'])) {
        $data['billaddr'] = $data['shipaddr'];
      }
      $details = $request->input('details', []);

      $record->update($data);

      // Replace all details
      $record->details()->delete();
      foreach ($details as $detail) {
        $detail['sq_id'] = $record->id;
        SalesQuotationDetail::create($detail);
      }

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'Sales quotation updated successfully',
        'data' => $record->load('details')
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => 'Failed to update sales quotation',
        'data' => null,
        'error' => $e->getMessage()
      ], 400);
    }
  }

  public function destroy($id)
  {
    $record = SalesQuotation::find($id);
    if (!$record) {
      return response()->json([
        'status' => 'error',
        'message' => 'Sales quotation not found',
        'data' => null
      ], 404);
    }

    if ($record->isvoid) {
      return response()->json([
        'status' => 'error',
        'message' => 'Sales quotation is already voided',
        'data' => null
      ], 400);
    }

    $record->isvoid = true;
    $record->save();

    return response()->json([
      'status' => 'success',
      'message' => 'Sales quotation voided successfully',
      'data' => $record
    ], 200);
  }
}
