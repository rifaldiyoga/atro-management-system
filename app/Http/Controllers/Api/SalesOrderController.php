<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function index()
    {
        $perPage = request()->query('per_page', 10);
        $search = request()->query('search');
        $sort = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');

        $query = SalesOrder::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(trxno) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $allowedSortFields = ['id', 'trxno', 'trxdate', 'status', 'total', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $records = $query->orderBy($sort, $direction)->paginate($perPage);

        return response()->json([
            'status' => 'success',
            'message' => 'Sales order list fetched successfully',
            'data' => $records->items(),
            'meta' => [
                'current_page' => $records->currentPage(),
                'last_page' => $records->lastPage(),
                'per_page' => $records->perPage(),
                'total' => $records->total(),
                'sort' => $sort,
                'direction' => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $record = SalesOrder::with('details')->find($id);
        if (!$record) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sales order fetched successfully',
            'data' => $record
        ], 200);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('details');
            $details = $request->input('details', []);

            $record = SalesOrder::create($data);

            foreach ($details as $detail) {
                $detail['so_id'] = $record->id;
                SalesOrderDetail::create($detail);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sales order created successfully',
                'data' => $record->load('details')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create sales order',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $record = SalesOrder::find($id);
        if (!$record) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order not found',
                'data' => null
            ], 404);
        }

        DB::beginTransaction();
        try {
            $data = $request->except('details');
            $details = $request->input('details', []);

            $record->update($data);

            // Replace all details
            $record->details()->delete();
            foreach ($details as $detail) {
                $detail['so_id'] = $record->id;
                SalesOrderDetail::create($detail);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sales order updated successfully',
                'data' => $record->load('details')
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update sales order',
                'data' => null,
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $record = SalesOrder::find($id);
        if (!$record) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order not found',
                'data' => null
            ], 404);
        }

        if ($record->isvoid) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sales order is already voided',
                'data' => null
            ], 400);
        }

        $record->isvoid = true;
        $record->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sales order voided successfully',
            'data' => $record
        ], 200);
    }
}
