<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesmanGroup;
use Illuminate\Http\Request;

class SalesmanGroupController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');

        $query = SalesmanGroup::query();

        if ($search) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
        }

        // Validate sort field
        $allowedSortFields = ['id', 'name', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // Validate direction
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $groups = $query->orderBy($sort, $direction)->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'message' => 'Salesman group list fetched successfully',
            'data' => $groups->items(),
            'meta' => [
                'current_page' => $groups->currentPage(),
                'last_page' => $groups->lastPage(),
                'per_page' => $groups->perPage(),
                'total' => $groups->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $group = SalesmanGroup::find($id);
        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Salesman group not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Salesman group fetched successfully',
            'data' => $group
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $group = SalesmanGroup::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman group created successfully',
                'data' => $group
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create salesman group',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $group = SalesmanGroup::find($id);
        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Salesman group not found',
                'data' => null
            ], 404);
        }
        try {
            $group->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman group updated successfully',
                'data' => $group
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update salesman group',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $group = SalesmanGroup::find($id);
        if (!$group) {
            return response()->json([
                'status' => 'error',
                'message' => 'Salesman group not found',
                'data' => null
            ], 404);
        }
        try {
            $group->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman group deleted successfully',
                'data' => null
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete salesman group',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
