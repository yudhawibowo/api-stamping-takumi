<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $materials = Material::latest()->get();
        return response()->json([
            'data' => MaterialResource::collection($materials),
            'message' => 'All Data Material',
            'success' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama_material' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $materials = Material::create([
            'nama_material' => $request->get('nama_material'),
            'product_name' => $request->get('product_name'),
            'product_number' => $request->get('product_number'),
            'p1' => $request->get('p1'),
            'l' => $request->get('l'),
            't' => $request->get('t'),
            'd' => $request->get('d'),
            'p2' => $request->get('p2'),
            'qty' => $request->get('qty')
        ]);

        return response()->json([
            'data' => new MaterialResource($materials),
            'message' => 'Data Material created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        //
        return response()->json([
            'data' => new MaterialResource($material),
            'message' => 'Data Material found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama_material' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $material->update([
            'nama_material' => $request->get('nama_material'),
            'product_name' => $request->get('product_name'),
            'product_number' => $request->get('product_number'),
            'p1' => $request->get('p1'),
            'l' => $request->get('l'),
            't' => $request->get('t'),
            'd' => $request->get('d'),
            'p2' => $request->get('p2'),
            'qty' => $request->get('qty')
        ]);

        return response()->json([
            'data' => new MaterialResource($material),
            'message' => 'Data Material Update successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material)
    {
        //
        $material->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Material deleted successfully',
            'success' => true
        ]);
    }
}
