<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salesman;
use App\Models\SalesOrder;
use App\Models\SalesQuotation;
use Illuminate\Http\Request;

class SalesmanController extends Controller
{
    public function index()
    {
        $perPage   = request()->query('per_page', 10);
        $search    = request()->query('search');
        $sort      = request()->query('sort', 'id');
        $direction = request()->query('direction', 'asc');
        $active    = request()->query('active');

        $query = Salesman::with('salesmanGroup');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(code) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        if (!is_null($active)) {
            $query->where('active', filter_var($active, FILTER_VALIDATE_BOOLEAN));
        }

        $allowedSortFields = ['id', 'name', 'code', 'email', 'active', 'created_at'];
        if (!in_array($sort, $allowedSortFields)) {
            $sort = 'id';
        }

        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $salesmen = $query->orderBy($sort, $direction)->paginate($perPage);

        return response()->json([
            'status'  => 'success',
            'message' => 'Salesman list fetched successfully',
            'data'    => $salesmen->items(),
            'meta'    => [
                'current_page' => $salesmen->currentPage(),
                'last_page'    => $salesmen->lastPage(),
                'per_page'     => $salesmen->perPage(),
                'total'        => $salesmen->total(),
                'sort'         => $sort,
                'direction'    => $direction,
            ]
        ], 200);
    }

    public function show($id)
    {
        $salesman = Salesman::with('salesmanGroup')->find($id);
        if (!$salesman) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Salesman not found',
                'data'    => null
            ], 404);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Salesman fetched successfully',
            'data'    => $salesman
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            if (empty($data['code']) || $data['code'] === 'AUTO') {
                $data['code'] = null; // Let the model booted event handle it
            }

            $salesman = Salesman::create($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Salesman created successfully',
                'data'    => $salesman->load('salesmanGroup')
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to create salesman',
                'data'    => null,
                'error'   => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        $salesman = Salesman::find($id);
        if (!$salesman) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Salesman not found',
                'data'    => null
            ], 404);
        }

        try {
            $data = $request->all();

            if (isset($data['code']) && $data['code'] === 'AUTO') {
                unset($data['code']); // Don't overwrite code on update
            }

            $salesman->update($data);

            return response()->json([
                'status'  => 'success',
                'message' => 'Salesman updated successfully',
                'data'    => $salesman->load('salesmanGroup')
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Failed to update salesman',
                'data'    => null,
                'error'   => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        $salesman = Salesman::find($id);
        if (!$salesman) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Salesman not found',
                'data'    => null
            ], 404);
        }

        $used = SalesOrder::where('srep_id', $salesman->id)->exists()
             || SalesQuotation::where('srep_id', $salesman->id)->exists();

        if ($used) {
            $salesman->active = false;
            $salesman->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Salesman is used in a transaction and has been set to inactive.'
            ], 200);
        }

        $salesman->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Salesman deleted successfully'
        ], 200);
    }
}
