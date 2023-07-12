<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\JabatanResource;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jabatans = Jabatan::latest()->get();
        return response()->json([
            'data' => JabatanResource::collection($jabatans),
            'message' => 'All Data Jabatan',
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
            'nama_jabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $jabatans = Jabatan::create([
            'nama_jabatan' => $request->get('nama_jabatan'),
            'bagian' => $request->get('bagian')
        ]);

        return response()->json([
            'data' => new JabatanResource($jabatans),
            'message' => 'Data Jabatan created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function show(Jabatan $jabatan)
    {
        //
        return response()->json([
            'data' => new JabatanResource($jabatan),
            'message' => 'Data Jabatan found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function edit(Jabatan $jabatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Jabatan $jabatan)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama_jabatan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $jabatan->update([
            'nama_jabatan' => $request->get('nama_jabatan'),
            'bagian' => $request->get('bagian')
        ]);

        return response()->json([
            'data' => new JabatanResource($jabatan),
            'message' => 'Data Jabatan Update successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Jabatan  $jabatan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Jabatan $jabatan)
    {
        //
        return response()->json([
            'data' => [],
            'message' => 'Data Jabatan deleted successfully',
            'success' => true
        ]);
    }
}
