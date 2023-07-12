<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\MesinResource;
use App\Models\Mesin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MesinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $mesins = Mesin::latest()->get();
        return response()->json([
            'data' => MesinResource::collection($mesins),
            'message' => 'All Data Mesin',
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
            'code_mesin' => 'required',
            'nama_mesin' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $mesins = Mesin::create([
            'code_mesin' => $request->get('code_mesin'),
            'nama_mesin' => $request->get('nama_mesin'),
            'tonase' => $request->get('tonase'),
            'sph' => $request->get('sph'),
            'capacity' => $request->get('capacity'),
            'status_mesin' => $request->get('status_mesin')
        ]);

        return response()->json([
            'data' => new MesinResource($mesins),
            'message' => 'Data Mesin created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function show(Mesin $mesin)
    {
        //
        return response()->json([
            'data' => new MesinResource($mesin),
            'message' => 'Data Mesin found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function edit(Mesin $mesin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mesin $mesin)
    {
        //
        $validator = Validator::make($request->all(), [
            'code_mesin' => 'required',
            'nama_mesin' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $mesin->update([
            'code_mesin' => $request->get('code_mesin'),
            'nama_mesin' => $request->get('nama_mesin'),
            'tonase' => $request->get('tonase'),
            'sph' => $request->get('sph'),
            'capacity' => $request->get('capacity'),
            'status_mesin' => $request->get('status_mesin')
        ]);

        return response()->json([
            'data' => new MesinResource($mesin),
            'message' => 'Data Mesin Update successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mesin  $mesin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mesin $mesin)
    {
        //
        $mesin->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Mesin deleted successfully',
            'success' => true
        ]);
    }
}
