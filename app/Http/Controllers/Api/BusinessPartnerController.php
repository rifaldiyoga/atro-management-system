<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BpAddr;
use App\Models\BusinessPartner;
use App\Models\SalesOrder;
use App\Models\SalesQuotation;
use App\Models\ItemSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessPartnerController extends Controller
{
  public function index()
  {
    $perPage   = request()->query('per_page', 10);
    $search    = request()->query('search');
    $sort      = request()->query('sort', 'id');
    $direction = request()->query('direction', 'asc');
    $bptype    = request()->query('bptype');

    $query = BusinessPartner::with('addresses');

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
          ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
          ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%']);
      });
    }

    if ($bptype) {
      $query->where('bptype', strtoupper($bptype));
    }

    $allowedSortFields = ['id', 'code', 'name', 'email', 'bptype', 'created_at'];
    if (!in_array($sort, $allowedSortFields)) {
      $sort = 'id';
    }

    $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

    $bps = $query->orderBy($sort, $direction)->paginate($perPage);

    return response()->json([
      'status'  => 'success',
      'message' => 'Business partner list fetched successfully',
      'data'    => $bps->items(),
      'meta'    => [
        'current_page' => $bps->currentPage(),
        'last_page'    => $bps->lastPage(),
        'per_page'     => $bps->perPage(),
        'total'        => $bps->total(),
        'sort'         => $sort,
        'direction'    => $direction,
      ]
    ], 200);
  }

  public function show($id)
  {
    $bp = BusinessPartner::with('addresses')->find($id);

    if (!$bp) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Business partner not found',
        'data'    => null
      ], 404);
    }

    return response()->json([
      'status'  => 'success',
      'message' => 'Business partner fetched successfully',
      'data'    => $bp
    ], 200);
  }

  public function store(Request $request)
  {
    DB::beginTransaction();
    try {
      $data      = $request->except('addresses');
      $addresses = $request->input('addresses', []);

      $bp = BusinessPartner::create($data);

      foreach ($addresses as $addr) {
        $addr['bp_id'] = $bp->id;
        BpAddr::create($addr);
      }

      DB::commit();

      return response()->json([
        'status'  => 'success',
        'message' => 'Business partner created successfully',
        'data'    => $bp->load('addresses')
      ], 201);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'  => 'error',
        'message' => 'Failed to create business partner',
        'data'    => null,
        'error'   => $e->getMessage()
      ], 400);
    }
  }

  public function update(Request $request, $id)
  {
    $bp = BusinessPartner::find($id);
    if (!$bp) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Business partner not found',
        'data'    => null
      ], 404);
    }

    DB::beginTransaction();
    try {
      $data      = $request->except('addresses');
      $addresses = $request->input('addresses');

      $bp->update($data);

      // Replace addresses if provided
      if (!is_null($addresses)) {
        $bp->addresses()->delete();
        foreach ($addresses as $addr) {
          $addr['bp_id'] = $bp->id;
          BpAddr::create($addr);
        }
      }

      DB::commit();

      return response()->json([
        'status'  => 'success',
        'message' => 'Business partner updated successfully',
        'data'    => $bp->load('addresses')
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'  => 'error',
        'message' => 'Failed to update business partner',
        'data'    => null,
        'error'   => $e->getMessage()
      ], 400);
    }
  }

  public function destroy($id)
  {
    $bp = BusinessPartner::find($id);
    if (!$bp) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Business partner not found',
        'data'    => null
      ], 404);
    }

    $used = SalesOrder::where('bp_id', $bp->id)->exists()
      || SalesQuotation::where('bp_id', $bp->id)->exists()
      || ItemSupplier::where('bp_id', $bp->id)->exists();

    if ($used) {
      $bp->active = false;
      $bp->save();

      return response()->json([
        'status'  => 'success',
        'message' => 'Business partner is used in a transaction and has been set to inactive.'
      ], 200);
    }

    DB::beginTransaction();
    try {
      $bp->addresses()->delete();
      $bp->delete();

      DB::commit();

      return response()->json([
        'status'  => 'success',
        'message' => 'Business partner deleted successfully'
      ], 200);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status'  => 'error',
        'message' => 'Failed to delete business partner',
        'error'   => $e->getMessage()
      ], 400);
    }
  }
}
