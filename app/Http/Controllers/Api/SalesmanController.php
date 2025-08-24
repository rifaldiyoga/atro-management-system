<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salesman;
use Illuminate\Http\Request;

class SalesmanController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');

        $query = Salesman::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Validate sort field
        $allowedSortFields = ['id', 'name', 'code', 'phone', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // Validate direction
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $salesmen = $query->orderBy($sort, $direction)->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'message' => 'Salesman list fetched successfully',
            'data' => $salesmen->items(),
            'meta' => [
                'current_page' => $salesmen->currentPage(),
                'last_page' => $salesmen->lastPage(),
                'per_page' => $salesmen->perPage(),
                'total' => $salesmen->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $salesman = Salesman::find($id);
        if (!$salesman) {
            return response()->json([
                'status' => 'error',
                'message' => 'Salesman not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Salesman fetched successfully',
            'data' => $salesman
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['code']) && $data['code'] === 'AUTO') {
                $data['code'] = null;
            }
            $salesman = Salesman::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman created successfully',
                'data' => $salesman
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create salesman',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $salesman = Salesman::find($id);
        if (!$salesman) {
            return response()->json([
                'status' => 'error',
                'message' => 'Salesman not found',
                'data' => null
            ], 404);
        }
        try {
            $data = $request->all();
            if (isset($data['code']) && $data['code'] === 'AUTO') {
                $data['code'] = null;
            }
            $salesman->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman updated successfully',
                'data' => $salesman
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update salesman',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $salesman = Salesman::find($id);
        if (!$salesman) {
            return response()->json([
                'status' => 'error',
                'message' => 'Salesman not found',
                'data' => null
            ], 404);
        }
        $used = false;
        $used = $used || \App\Models\Order::where('salesman_id', $salesman->id)->exists();
        $used = $used || \App\Models\OfferRequest::where('salesman_id', $salesman->id)->exists();
        if ($used) {
            $salesman->is_active = false;
            $salesman->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman is used in a transaction and has been set to inactive.'
            ], 200);
        } else {
            $salesman->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Salesman deleted successfully'
            ], 200);
        }
    }
}
