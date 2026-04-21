<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ItemGrp;
use Illuminate\Http\Request;

class ItemGrpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemGrps = ItemGrp::all();
        return response()->json($itemGrps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:125',
            'level' => 'required|integer',
            'up_id' => 'nullable|integer',
            'itemtype_code' => 'required|string|max:25',
            'active' => 'boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $itemGrp = ItemGrp::create($validatedData);

        return response()->json($itemGrp, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $itemGrp = ItemGrp::findOrFail($id);
        return response()->json($itemGrp);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $itemGrp = ItemGrp::findOrFail($id);

        $validatedData = $request->validate([
            'code' => 'sometimes|required|string|max:50',
            'name' => 'sometimes|required|string|max:125',
            'level' => 'sometimes|required|integer',
            'up_id' => 'nullable|integer',
            'itemtype_code' => 'sometimes|required|string|max:25',
            'active' => 'boolean',
            'created_by' => 'nullable|integer',
            'updated_by' => 'nullable|integer',
        ]);

        $itemGrp->update($validatedData);

        return response()->json($itemGrp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itemGrp = ItemGrp::findOrFail($id);
        $itemGrp->delete();

        return response()->json(null, 204);
    }
}
