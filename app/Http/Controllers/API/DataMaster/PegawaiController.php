<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\PegawaiResource;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $pegawai = Pegawai::with('jabatan:id,nama_jabatan,bagian','shift:id,nama_shift,waktu_mulai,waktu_selesai');
        //Sort by
        if($request->sortBy && in_array($request->sortBy,['nama','alamat','no_hp','bagian','username'])){
            $sortBy=$request->sortBy;
        } else {
            $sortBy='id';
        }
        //Sort order by
        if($request->sortOrder && in_array($request->sortOrder,['asc','desc'])){
            $sortOrder=$request->sortOrder;
        } else {
            $sortOrder='desc';
        }

        //Paginate
        if($request->perPage){
            $perPage=$request->perPage;
        } else {
            $perPage="5";
        }

        if($request->paginate){  
            $pegawais = $pegawai->orderBy($sortBy,$sortOrder)->paginate($perPage);
        } else {
            $pegawais = $pegawai->orderBy($sortBy,$sortOrder)->get();
        }

        return response()->json([
            'data' => PegawaiResource::collection($pegawais),
            'message' => 'All Data Pegawai',
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
            'nama' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $pegawais = Pegawai::create([
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'no_hp' => $request->get('no_hp'),
            'bagian' => $request->get('bagian'),
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
            'id_jabatan' => $request->get('id_jabatan'),
            'id_shift' => $request->get('id_shift')
        ]);

        return response()->json([
            'data' => new PegawaiResource($pegawais),
            'message' => 'Data Pegawai created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function show(Pegawai $pegawai)
    {
        //
        return response()->json([
            'data' => new PegawaiResource($pegawai),
            'message' => 'Data Pegawai found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function edit(Pegawai $pegawai)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            //'username' => 'required',
            //'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $pegawai->update([
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'no_hp' => $request->get('no_hp'),
            'bagian' => $request->get('bagian'),
            //'username' => $request->get('username'),
            //'password' => bcrypt($request->get('password')),
            'id_jabatan' => $request->get('id_jabatan'),
            'id_shift' => $request->get('id_shift')
        ]);

        return response()->json([
            'data' => new PegawaiResource($pegawai),
            'message' => 'Data Pegawai Update successfully.',
            'success' => true
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pegawai  $pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pegawai $pegawai)
    {
        //
        $pegawai->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Pegawai deleted successfully',
            'success' => true
        ]);
    }
}
