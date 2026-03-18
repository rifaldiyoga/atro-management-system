<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemSupplier;
use App\Models\SalesOrderDetail;
use App\Models\SalesQuotationDetail;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $perPage   = request()->query('per_page', 10);
        $search    = request()->query('search');
        $sort      = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');
        $active    = request()->query('active');
        $itemtype  = request()->query('itemtype');

        $query = Item::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if (!is_null($active)) {
            $query->where('active', filter_var($active, FILTER_VALIDATE_BOOLEAN));
        }

        $allowedItemTypes = ['GOOD', 'SERV', 'MFG', 'RAW'];
        if ($itemtype && in_array(strtoupper($itemtype), $allowedItemTypes)) {
            $query->where('itemtype', strtoupper($itemtype));
        }

        $allowedSortFields = ['id', 'code', 'name', 'unit', 'price', 'active', 'itemtype', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $items = $query->orderBy($sort, $direction)->paginate($perPage);

        return response()->json([
            'status'  => 'success',
            'message' => 'Item list fetched successfully',
            'data'    => $items->items(),
            'meta'    => [
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
                'per_page'     => $items->perPage(),
                'total'        => $items->total(),
                'sort'         => $sort,
                'direction'    => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Item not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Item fetched successfully',
            'data'    => $item
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            // Auto-generate code if not provided or set to 'AUTO'
            if (empty($data['code']) || $data['code'] === 'AUTO') {
                $data['code'] = null; // Let the model booted event handle it
            }

            // Validate and normalise itemtype
            $allowedItemTypes = ['GOOD', 'SERV', 'MFG', 'RAW'];
            if (isset($data['itemtype'])) {
                $data['itemtype'] = strtoupper($data['itemtype']);
                if (!in_array($data['itemtype'], $allowedItemTypes)) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Invalid itemtype. Allowed values: GOOD, SERV, MFG, RAW',
                        'data'    => null,
                    ], 422);
                }
            }

            $item = Item::create($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Item created successfully',
                'data'    => $item
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create item',
                'data'    => null,
                'error'   => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Item not found',
                'data'    => null
            ], 404);
        }

        try {
            $data = $request->all();

            if (isset($data['code']) && $data['code'] === 'AUTO') {
                unset($data['code']); // Don't overwrite code on update
            }

            // Validate and normalise itemtype
            $allowedItemTypes = ['GOOD', 'SERV', 'MFG', 'RAW'];
            if (isset($data['itemtype'])) {
                $data['itemtype'] = strtoupper($data['itemtype']);
                if (!in_array($data['itemtype'], $allowedItemTypes)) {
                    return response()->json([
                        'status'  => 'error',
                        'message' => 'Invalid itemtype. Allowed values: GOOD, SERV, MFG, RAW',
                        'data'    => null,
                    ], 422);
                }
            }

            $item->update($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Item updated successfully',
                'data'    => $item
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to update item',
                'data'    => null,
                'error'   => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $item = Item::find($id);
        if (!$item) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Item not found',
                'data'    => null
            ], 404);
        }

        $used = SalesOrderDetail::where('item_id', $item->id)->exists()
             || SalesQuotationDetail::where('item_id', $item->id)->exists()
             || ItemSupplier::where('item_id', $item->id)->exists();

        if ($used) {
            $item->active = false;
            $item->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Item is used in a transaction and has been set to inactive.'
            ], 200);
        }

        $item->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Item deleted successfully'
        ], 200);
    }
}
