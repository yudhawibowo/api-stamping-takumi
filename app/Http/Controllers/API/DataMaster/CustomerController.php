<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = Customer::latest()->get();
        return response()->json([
            'data' => CustomerResource::collection($customers),
            'message' => 'All Data Customer',
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $customers = Customer::create([
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'no_hp' => $request->get('no_hp'),
            'terakhir_order' => $request->get('terakhir_order'),
            'email' => $request->get('email'),
            'id_pegawai' => $request->get('id_pegawai'),
        ]);

        return response()->json([
            'data' => new CustomerResource($customers),
            'message' => 'Data Customer created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
        return response()->json([
            'data' => new CustomerResource($customer),
            'message' => 'Data Customer found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $customer->update([
            'nama' => $request->get('nama'),
            'alamat' => $request->get('alamat'),
            'no_hp' => $request->get('no_hp'),
            'terakhir_order' => $request->get('terakhir_order'),
            'email' => $request->get('email'),
            'id_pegawai' => $request->get('id_pegawai'),
        ]);

        return response()->json([
            'data' => new CustomerResource($customer),
            'message' => 'Data Customer Update successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
        $customer->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Customer deleted successfully',
            'success' => true
        ]);
    }
}
