<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reg;
use Illuminate\Http\Request;

class RegController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $search = $request->query('search', '');

    $query = Reg::query();

    if (!empty($search)) {
      $query->where('code', 'ilike', '%' . $search . '%')
        ->orWhere('name', 'ilike', '%' . $search . '%');
    }

    $regs = $query->orderBy('code', 'asc')->get();

    return response()->json([
      'status'  => 'success',
      'message' => 'Reg list fetched successfully',
      'data'    => $regs
    ], 200);
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'code' => 'nullable|string|max:255',
      'name' => 'nullable|string|max:255',
      'value' => 'nullable|string',
      'isvisible' => 'nullable|boolean',
      'modul_code' => 'nullable|string|max:255',
      'valeditor' => 'nullable|string|max:255',
      'type' => 'nullable|string|max:255',
      'note' => 'nullable|string',
      'index' => 'nullable|integer',
    ]);

    $reg = Reg::create($validated);

    return response()->json([
      'status'  => 'success',
      'message' => 'Reg created successfully',
      'data'    => $reg
    ], 201);
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $reg = Reg::find($id);

    if (!$reg) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Reg not found',
        'data'    => null
      ], 404);
    }

    return response()->json([
      'status'  => 'success',
      'message' => 'Reg fetched successfully',
      'data'    => $reg
    ], 200);
  }

  /**
   * Display the specified resource by code.
   */
  public function getByCode($code)
  {
    $reg = Reg::where('code', $code)->first();

    if (!$reg) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Reg not found',
        'data'    => null
      ], 404);
    }

    return response()->json([
      'status'  => 'success',
      'message' => 'Reg fetched successfully',
      'data'    => $reg
    ], 200);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $reg = Reg::find($id);

    if (!$reg) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Reg not found',
        'data'    => null
      ], 404);
    }

    $validated = $request->validate([
      'code' => 'sometimes|nullable|string|max:255',
      'name' => 'sometimes|nullable|string|max:255',
      'value' => 'sometimes|nullable|string',
      'isvisible' => 'sometimes|nullable|boolean',
      'modul_code' => 'sometimes|nullable|string|max:255',
      'valeditor' => 'sometimes|nullable|string|max:255',
      'type' => 'sometimes|nullable|string|max:255',
      'note' => 'sometimes|nullable|string',
      'index' => 'sometimes|nullable|integer',
    ]);

    $reg->update($validated);

    return response()->json([
      'status'  => 'success',
      'message' => 'Reg updated successfully',
      'data'    => $reg
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $reg = Reg::find($id);

    if (!$reg) {
      return response()->json([
        'status'  => 'error',
        'message' => 'Reg not found',
        'data'    => null
      ], 404);
    }

    $reg->delete();

    return response()->json([
      'status'  => 'success',
      'message' => 'Reg deleted successfully'
    ], 200);
  }
}
