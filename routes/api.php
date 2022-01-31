<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\KotaKabupatenController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\WeightGirlController;
use App\Http\Controllers\WeightBoyController;
use App\Http\Controllers\HeightGirlController;
use App\Http\Controllers\HeightBoyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weight-boy/all',[WeightBoyController::class,'all']);
Route::get('/weight-girl/all',[WeightGirlController::class,'all']);
Route::get('/height-boy/all',[HeightBoyController::class,'all']);
Route::get('/height-girl/all',[HeightGirlController::class,'all']);


Route::get('/provinsi/all',[ProvinsiController::class,'all']);
Route::get('/kota-kabupaten/by-provinsi/{provinsi_id}',[KotaKabupatenController::class,'showByProvinsi']);
Route::get('/kecamatan/by-kota-kabupaten/{kota_kabupaten_id}',[KecamatanController::class,'showByKotaKabupaten']);
Route::get('/kelurahan/by-kecamatan/{kecamatan_id}',[KelurahanController::class,'showByKecamatan']);
Route::get('/kelurahan/detail/{id}',[KelurahanController::class,'show']);

Route::post('/registration',[RegisterController::class,'store']);

Route::post('/login',[LoginController::class,'loginUser']);