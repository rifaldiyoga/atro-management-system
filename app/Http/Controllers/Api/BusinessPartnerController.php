<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessPartner;
use Illuminate\Http\Request;

class BusinessPartnerController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');
        $partnerType = request()->query('partner_type');

        $query = BusinessPartner::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if ($partnerType) {
            $query->where('partner_type', $partnerType);
        }

        // Validate sort field
        $allowedSortFields = ['id', 'code', 'name', 'phone', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // Validate direction
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $bps = $query->orderBy($sort, $direction)->paginate($perPage);
        return response()->json([
            'status' => 'success',
            'message' => 'Business partner list fetched successfully',
            'data' => $bps->items(),
            'meta' => [
                'current_page' => $bps->currentPage(),
                'last_page' => $bps->lastPage(),
                'per_page' => $bps->perPage(),
                'total' => $bps->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $bp = BusinessPartner::find($id);
        if (!$bp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Business partner not found',
                'data' => null
            ], 404);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Business partner fetched successfully',
            'data' => $bp
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $bp = BusinessPartner::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Business partner created successfully',
            'data' => $bp
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $bp = BusinessPartner::findOrFail($id);
        $data = $request->all();

        $bp->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Business partner updated successfully',
            'data' => $bp
        ], 200);
    }

    public function destroy($id)
    {
        $bp = BusinessPartner::findOrFail($id);
        $used = false;
        // Check if used in Order (customer_id)
        $used = $used || \App\Models\Order::where('customer_id', $bp->id)->exists();
        // Check if used in OrderItem (supplier_id)
        $used = $used || \App\Models\OrderItem::where('supplier_id', $bp->id)->exists();
        // Check if used in OfferRequest (customer_id)
        $used = $used || \App\Models\OfferRequest::where('customer_id', $bp->id)->exists();
        // Check if used in OfferRequestItem (supplier_id)
        $used = $used || \App\Models\OfferRequestItem::where('supplier_id', $bp->id)->exists();
        if ($used) {
            $bp->is_active = false;
            $bp->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Business partner is used in a transaction and has been set to inactive.'
            ], 200);
        } else {
            $bp->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Business partner deleted successfully'
            ], 200);
        }
    }
}
