<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemGrp;
use Illuminate\Http\Request;

class ItemGrpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage   = request()->query('per_page', 10);
        $search    = request()->query('search');
        $sort      = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');
        $active    = request()->query('active');

        $query = ItemGrp::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if (!is_null($active)) {
            $query->where('active', filter_var($active, FILTER_VALIDATE_BOOLEAN));
        }

        $allowedSortFields = ['id', 'code', 'name', 'level', 'itemtype_code', 'active', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $itemGrps = $query->orderBy($sort, $direction)->paginate($perPage);

        return response()->json([
            'status'  => 'success',
            'message' => 'Item group list fetched successfully',
            'data'    => $itemGrps->items(),
            'meta'    => [
                'current_page' => $itemGrps->currentPage(),
                'last_page'    => $itemGrps->lastPage(),
                'per_page'     => $itemGrps->perPage(),
                'total'        => $itemGrps->total(),
                'sort'         => $sort,
                'direction'    => $direction,
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            if (empty($data['code']) || $data['code'] === 'AUTO') {
                $data['code'] = null; // Let the model booted event handle it
            }

            $request->replace($data);

            $validatedData = $request->validate([
                'code' => 'nullable|string|max:50',
                'name' => 'required|string|max:125',
                'level' => 'required|integer',
                'up_id' => 'nullable|integer',
                'itemtype_code' => 'required|string|max:25',
                'active' => 'boolean',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ]);

            $itemGrp = ItemGrp::create($validatedData);

            return response()->json([
                'status'  => 'success',
                'message' => 'Item group created successfully',
                'data'    => $itemGrp
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create item group',
                'data'    => null,
                'error'   => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $itemGrp = ItemGrp::find($id);
        if (!$itemGrp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Item group not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Item group fetched successfully',
            'data'    => $itemGrp
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $itemGrp = ItemGrp::find($id);
        if (!$itemGrp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Item group not found',
                'data'    => null
            ], 404);
        }

        try {
            $data = $request->all();

            if (isset($data['code']) && $data['code'] === 'AUTO') {
                unset($data['code']);
                $request->replace($data);
            }

            $validatedData = $request->validate([
                'code' => 'sometimes|nullable|string|max:50',
                'name' => 'sometimes|required|string|max:125',
                'level' => 'sometimes|required|integer',
                'up_id' => 'nullable|integer',
                'itemtype_code' => 'sometimes|required|string|max:25',
                'active' => 'boolean',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ]);

            $itemGrp->update($validatedData);

            return response()->json([
                'status'  => 'success',
                'message' => 'Item group updated successfully',
                'data'    => $itemGrp
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to update item group',
                'data'    => null,
                'error'   => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itemGrp = ItemGrp::find($id);
        if (!$itemGrp) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Item group not found',
                'data'    => null
            ], 404);
        }

        $itemGrp->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Item group deleted successfully'
        ], 200);
    }
}
