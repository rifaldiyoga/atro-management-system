<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $items = OrderItem::paginate($perPage);
        return response()->json([
            'status' => 'success',
            'message' => 'Order item list fetched successfully',
            'data' => $items->items(),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ]
        ], 200);
    }

    public function show($id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Order item fetched successfully',
            'data' => $item
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $item = OrderItem::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Order item created successfully',
                'data' => $item
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create order item',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found',
                'data' => null
            ], 404);
        }
        try {
            $item->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Order item updated successfully',
                'data' => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update order item',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $item = OrderItem::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order item not found',
                'data' => null
            ], 404);
        }
        try {
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Order item deleted successfully',
                'data' => null
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete order item',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
