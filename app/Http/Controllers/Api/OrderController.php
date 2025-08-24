<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');

        $query = Order::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(po_no) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(ph_no) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(rfq_number) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Validate sort field
        $allowedSortFields = ['id', 'po_no', 'ph_no', 'rfq_number', 'trxdate', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // Validate direction
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $orders = $query->orderBy($sort, $direction)->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'message' => 'Order list fetched successfully',
            'data' => $orders->items(),
            'meta' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Order fetched successfully',
            'data' => $order
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $order = Order::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully',
                'data' => $order
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
                'data' => null
            ], 404);
        }
        try {
            $order->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Order updated successfully',
                'data' => $order
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update order',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
                'data' => null
            ], 404);
        }
        try {
            $order->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Order deleted successfully',
                'data' => null
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete order',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
