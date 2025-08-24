<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');

        $query = Item::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Validate sort field
        $allowedSortFields = ['id', 'code', 'name', 'price', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // Validate direction
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $items = $query->orderBy($sort, $direction)->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'message' => 'Item list fetched successfully',
            'data' => $items->items(),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Item fetched successfully',
            'data' => $item
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['code']) && $data['code'] === 'AUTO') {
                $data['code'] = null;
            }
            $item = Item::create($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Item created successfully',
                'data' => $item
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create item',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found',
                'data' => null
            ], 404);
        }
        try {
            $data = $request->all();
            if (isset($data['code']) && $data['code'] === 'AUTO') {
                $data['code'] = null;
            }
            $item->update($data);
            return response()->json([
                'status' => 'success',
                'message' => 'Item updated successfully',
                'data' => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update item',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not found',
                'data' => null
            ], 404);
        }
        $used = false;
        $used = $used || \App\Models\OrderItem::where('item_id', $item->id)->exists();
        $used = $used || \App\Models\OfferRequestItem::where('item_id', $item->id)->exists();
        if ($used) {
            $item->is_active = false;
            $item->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Item is used in a transaction and has been set to inactive.'
            ], 200);
        } else {
            $item->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Item deleted successfully'
            ], 200);
        }
    }
}
