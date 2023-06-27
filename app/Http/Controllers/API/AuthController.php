<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        try {
            // Validasi
            $messages = [
                'required' => 'Kolom :attribute wajib diisi.',
                'email' => 'Kolom :attribute format tidak valid.'
            ];

            $rules = [
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
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
         
            $user = User::where('email', $request->email)->first();
            // dd($user);
            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'code' => 400,
                    'success' => false,
                    'message' => 'Username / password salah.'
                ], 400);
            }
         
            return response()->json([
                'auth_user' => $user,
                'token' => $user->createToken($request->device_name)->plainTextToken
            ]);
        } catch (\Exception $e) {
            Log::error("Error: {$e->getMessage()}, File: {$e->getFile()}, Line: {$e->getLine()}");
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT.'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {

            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil!'
            ]);

        } catch (\Exception $e) {
            Log::error("Error: {$e->getMessage()}, File: {$e->getFile()}, Line: {$e->getLine()}");
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT.'
            ], 500);
        }
    }

    public function profile(Request $request)
    {
        try {

            return response()->json([
                'success' => true,
                'data' => $request->user()
            ]);

        } catch (\Exception $e) {
            Log::error("Error: {$e->getMessage()}, File: {$e->getFile()}, Line: {$e->getLine()}");
            return response()->json([
                'code' => 500,
                'success' => false,
                'message' => 'Mohon maaf permintaan anda tidak dapat diproses. Silahkan hubungi IT.'
            ], 500);
        }
    }
}
