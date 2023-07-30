<?php

namespace App\Http\Controllers\API\DataMaster;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $orders = Order::latest()->get();
        return response()->json([
            'data' => OrderResource::collection($orders),
            'message' => 'All Data Order',
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
        //Request File
        $image = null;
        if($request->upload_file){
            //upload file disini
            $fileName = $this->generateRandomString();
            $extention = $request->file->extention();
            $image = $fileName.'.'.$extention;
            Storage::putFileAs('files',$request->file, $image);
        }
        
        //
        $validator = Validator::make($request->all(), [
            'id_customer' => 'required',
            'po_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $orders = Order::create([
            'tgl_order' => $request->get('tgl_order'),
            'id_customer' => $request->get('id_customer'),
            'po_number' => $request->get('po_number'),
            'quotation_number' => $request->get('quotation_number'),
            'so_number' => $request->get('so_number'),
            'product_name' => $request->get('product_name'),
            'product_number' => $request->get('product_number'),
            'qty' => $request->get('qty'),
            'material_supply' => $request->get('material_supply'),
            'internal_order_number' => $request->get('internal_order_number'),
            'notes' => $request->get('notes'),
            'upload_file' => $request['upload_file'] = $image, //$request->get('upload_file'),
            'id_pegawai' => $request->get('id_pegawai')
        ]);

        return response()->json([
            'data' => new OrderResource($orders),
            'message' => 'Data Order created successfully.',
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
        return response()->json([
            'data' => new OrderResource($order),
            'message' => 'Data Order found',
            'success' => true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
        $validator = Validator::make($request->all(), [
            'id_customer' => 'required',
            'po_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $order->update([
            'tgl_order' => $request->get('tgl_order'),
            'id_customer' => $request->get('id_customer'),
            'po_number' => $request->get('po_number'),
            'quotation_number' => $request->get('quotation_number'),
            'so_number' => $request->get('so_number'),
            'product_name' => $request->get('product_name'),
            'product_number' => $request->get('product_number'),
            'qty' => $request->get('qty'),
            'material_supply' => $request->get('material_supply'),
            'internal_order_number' => $request->get('internal_order_number'),
            'notes' => $request->get('notes'),
            'upload_file' => $request->get('upload_file'),
            'id_pegawai' => $request->get('id_pegawai')
        ]);

        return response()->json([
            'data' => new OrderResource($order),
            'message' => 'Data Order Update successfully.',
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
        $order->delete();

        return response()->json([
            'data' => [],
            'message' => 'Data Order deleted successfully',
            'success' => true
        ]);
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
}
