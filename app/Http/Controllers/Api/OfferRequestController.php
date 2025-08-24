<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OfferRequest;
use Illuminate\Http\Request;

class OfferRequestController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');

        $query = OfferRequest::with('customer');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(ph_no) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(po_no) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Validate sort field
        $allowedSortFields = ['id', 'ph_no', 'po_no', 'trxdate', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        // Validate direction
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $offerRequests = $query->orderBy($sort, $direction)->paginate($perPage);
        $data = collect($offerRequests->items())->map(function ($offerRequest) {
            $arr = $offerRequest->toArray();
            unset($arr['customer']);
            $arr['customer_name'] = $offerRequest->customer ? $offerRequest->customer->name : null;
            return $arr;
        });
        return response()->json([
            'status' => 'success',
            'message' => 'Offer request list fetched successfully',
            'data' => $data,
            'meta' => [
                'current_page' => $offerRequests->currentPage(),
                'last_page' => $offerRequests->lastPage(),
                'per_page' => $offerRequests->perPage(),
                'total' => $offerRequests->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $offerRequest = OfferRequest::with('customer')->find($id);
        if (!$offerRequest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Offer request not found',
                'data' => null
            ], 404);
        }
        $data = $offerRequest->toArray();
        unset($data['customer']);
        $data['customer_name'] = $offerRequest->customer ? $offerRequest->customer->name : null;
        return response()->json([
            'status' => 'success',
            'message' => 'Offer request fetched successfully',
            'data' => $data
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $offerRequest = OfferRequest::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Offer request created successfully',
                'data' => $offerRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create offer request',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $offerRequest = OfferRequest::find($id);
        if (!$offerRequest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Offer request not found',
                'data' => null
            ], 404);
        }
        try {
            $offerRequest->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Offer request updated successfully',
                'data' => $offerRequest
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update offer request',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $offerRequest = OfferRequest::find($id);
        if (!$offerRequest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Offer request not found',
                'data' => null
            ], 404);
        }
        try {
            $offerRequest->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Offer request deleted successfully',
                'data' => null
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to delete offer request',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
