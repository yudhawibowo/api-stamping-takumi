<?php

namespace App\Http\Controllers\API\AccessControl;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\User\PermissionService;
use App\Services\User\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            // Validasi
            $user = Auth::user();
            if(!$user->isAbleTo('read-acl'))
            {
                return response()->json([
                    'code' => 500,
                    'success' => false,
                    'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT untuk menambahkan hak akses Read ACL.'
                ], 500);
            }

            $data = [
                'per_page' => !empty($request->per_page) ? $request->per_page : 10,
                'page' => !empty($request->page) ? $request->page : 1,
                'filters' => !empty($request->filters) ? json_decode($request->filters, true) : [],
                'search' => $request->search,
                'sort_by' => $request->sort_by ?? 'id',
                'sort' => $request->sort ?? 'asc'
            ];

            $response = (new RoleService())->getList($data);

            return response()->json($response, 200);
            
        } catch (\Exception $e) {
            Log::error("Error: {$e->getMessage()}, File: {$e->getFile()}, Line: {$e->getLine()}");
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT.'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        if(!$user->isAbleTo('create-acl'))
        {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT untuk menambahkan hak akses Create ACL.'
            ], 500);
        }

        // Validasi
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'array' => 'Kolom :attribute type data harus array.',
        ];

        $rules = [
            'display_name' => 'required',
            'permission_id' => 'required|array'
        ];
            
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'code' => 400,
                'success' => false,
                'message' => 'Validasi error',
                'errors' => $validator->errors()
            ], 400);
        }

        // END VALIDASI

        $response = (new RoleService())->store($request->all());

        return response()->json($response, $response['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = Auth::user();
        if(!$user->isAbleTo('read-acl'))
        {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT untuk menambahkan hak akses Read ACL.'
            ], 500);
        }

        $response = (new RoleService())->findById($id);

        return response()->json($response, $response['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $user = Auth::user();
        if(!$user->isAbleTo('update-acl'))
        {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT untuk menambahkan hak akses Update ACL.'
            ], 500);
        }

        // Validasi
        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'array' => 'Kolom :attribute type data harus array.',
        ];

        $rules = [
            'display_name' => 'required',
            'permission_id' => 'required|array'
        ];
            
        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails())
        {
            return response()->json([
                'code' => 400,
                'success' => false,
                'message' => 'Validasi error',
                'errors' => $validator->errors()
            ], 400);
        }

        $response = (new RoleService())->update($request->all(), $id);

        return response()->json($response, $response['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = Auth::user();
        if(!$user->isAbleTo('delete-acl'))
        {
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT untuk menambahkan hak akses Delete ACL.'
            ], 500);
        }

        $response = (new RoleService())->delete($id);

        return response()->json($response, $response['code']);
    }
}
