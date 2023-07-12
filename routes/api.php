<?php

use App\Http\Controllers\API\AccessControl\PermissionController;
use App\Http\Controllers\API\AccessControl\RoleController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->prefix('v1_0')->group(function() {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);

    // PERMISSION
    Route::get('/access-control/permissions', [PermissionController::class, 'index']);
    Route::get('/access-control/permissions/{id}', [PermissionController::class, 'show']);
    Route::patch('/access-control/permissions/{id}', [PermissionController::class, 'update']);
    Route::delete('/access-control/permissions/{id}', [PermissionController::class, 'destroy']);
    Route::post('/access-control/permissions', [PermissionController::class, 'store']);

    // ROLE
    Route::get('/access-control/roles', [RoleController::class, 'index']);
    Route::get('/access-control/roles/{id}', [RoleController::class, 'show']);
    Route::patch('/access-control/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/access-control/roles/{id}', [RoleController::class, 'destroy']);
    Route::post('/access-control/roles', [RoleController::class, 'store']);

    // PEGAWAI
    Route::resource('data-master/pegawai', \App\Http\Controllers\API\DataMaster\PegawaiController::class);

    // JABATAN
    Route::resource('data-master/jabatan', \App\Http\Controllers\API\DataMaster\JabatanController::class);

    // SHIFT
    Route::resource('data-master/shift', \App\Http\Controllers\API\DataMaster\ShiftController::class);

    // CUSTOMER
    Route::resource('data-master/customer', \App\Http\Controllers\API\DataMaster\CustomerController::class);

    // MATERIAL
    Route::resource('data-master/material', \App\Http\Controllers\API\DataMaster\MaterialController::class);

    // MESIN
    Route::resource('data-master/mesin', \App\Http\Controllers\API\DataMaster\MesinController::class);

    // ORDER
    Route::resource('data-master/order', \App\Http\Controllers\API\DataMaster\OrderController::class);

});

Route::prefix('v1_0')->group(function(){
    Route::post('/auth/login', [AuthController::class, 'login']);
});
