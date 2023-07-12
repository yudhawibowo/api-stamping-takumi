<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShiftResource;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $shifts = Shift::latest()->get();
        return response()->json([
            'data' => ShiftResource::collection($shifts),
            'message' => 'All Data Shift',
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
            'nama_shift' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $shifts = shift::create([
            'nama_shift' => $request->get('nama_shift'),
            'waktu_mulai' => $request->get('waktu_mulai'),
            'waktu_selesai' => $request->get('waktu_selesai')
        ]);

        return response()->json([
            'data' => new ShiftResource($shifts),
            'message' => 'Data Shift created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function show(Shift $shift)
    {
        //
        return response()->json([
            'data' => new ShiftResource($shift),
            'message' => 'Data Shift found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function edit(Shift $shift)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shift $shift)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama_shift' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $shift->update([
            'nama_shift' => $request->get('nama_shift'),
            'waktu_mulai' => $request->get('waktu_mulai'),
            'waktu_selesai' => $request->get('waktu_selesai')
        ]);

        return response()->json([
            'data' => new ShiftResource($shift),
            'message' => 'Data Shift Update successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shift  $shift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shift $shift)
    {
        //
        $shift->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Shift deleted successfully',
            'success' => true
        ]);
        
    }
}
