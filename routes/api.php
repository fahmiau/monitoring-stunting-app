<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MotherController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\DataChildrenController;
use App\Http\Controllers\KotaKabupatenController;
use App\Http\Controllers\StatusChildrenController;
use App\Models\Article;

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

Route::get('/weight-boy/all',[GraphController::class,'getBoyWeight']);
Route::get('/weight-girl/all',[GraphController::class,'getGirlWeight']);
Route::get('/height-boy/all',[GraphController::class,'getBoyHeight']);
Route::get('/height-girl/all',[GraphController::class,'getGirlHeight']);
Route::get('/graph/{jk}/{type}/{children_id}',[GraphController::class,'getWithDataChildren']);


Route::get('/provinsi/all',[ProvinsiController::class,'all']);
Route::get('/kota-kabupaten/by-provinsi/{provinsi_id}',[KotaKabupatenController::class,'showByProvinsi']);
Route::get('/kecamatan/by-kota-kabupaten/{kota_kabupaten_id}',[KecamatanController::class,'showByKotaKabupaten']);
Route::get('/kelurahan/by-kecamatan/{kecamatan_id}',[KelurahanController::class,'showByKecamatan']);
Route::get('/kelurahan/detail/{id}',[KelurahanController::class,'show']);
Route::get('/kelurahan/user/{user_id}',[KelurahanController::class,'showByUserId']);


Route::post('/login',[LoginController::class,'loginUser']);
Route::post('/register',[RegisterController::class,'register']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout',[LoginController::class,'logoutUser']);

    Route::get('/dashboard',[LoginController::class,'dashboard']);
    
    Route::get('/mother/all',[MotherController::class,'index']);
    Route::get('/mother/has-children',[MotherController::class,'getMotherHasChildren']);
    Route::get('/mother/{user_id}',[MotherController::class,'getMotherByUserId']);
    Route::post('/mother/add',[MotherController::class,'store']);
    Route::post('/mother/update/{id}',[MotherController::class,'update']);
    Route::delete('/mother/delete/{id}',[MotherController::class,'destroy']);
    
    Route::post('/children/add',[ChildrenController::class,'store']);
    Route::get('/children/all',[ChildrenController::class,'getAllChildren']);
    Route::get('/children/all/provinsi/{provinsi_id}',[ChildrenController::class,'getAllChildrenByProvinsi']);
    Route::get('/children/all/kota-kabupaten/{kota_kabupaten_id}',[ChildrenController::class,'getAllChildrenByKotaKabupaten']);
    Route::get('/children/all/kecamatan/{kecamatan_id}',[ChildrenController::class,'getAllChildrenByKecamatan']);
    Route::get('/children/all/kelurahan/{kelurahan_id}',[ChildrenController::class,'getAllChildrenByKelurahan']);
    Route::get('/children/id/{id}',[ChildrenController::class,'getChildrenById']);
    Route::get('/children/mother_id/{mother_id}',[ChildrenController::class,'getChildrenByMotherId']);
    
    Route::post('/data-children/add',[DataChildrenController::class,'store']);
    Route::get('/data-children/by-child-id/{children_id}',[DataChildrenController::class,'getByChild']);
    
    Route::get('/status-stunting/all/provinsi/{id}',[StatusChildrenController::class,'getByProvinsi']);
    Route::get('/status-stunting/all/kota-kabupaten/{id}',[StatusChildrenController::class,'getByKotaKabupaten']);
    Route::get('/status-stunting/all/kecamatan/{id}',[StatusChildrenController::class,'getByKecamatan']);
    Route::get('/status-stunting/all/kelurahan/{id}',[StatusChildrenController::class,'getByKelurahan']);
    
    Route::get('/article/published',[ArticleController::class,'getPublishedArticle']);
    Route::get('/article/all',[ArticleController::class,'index']);
    Route::get('/article/show/{slug}',[ArticleController::class,'show']);
    Route::get('/article/admin/{slug}',[ArticleController::class,'showAdmin']);

    Route::post('/article/store',[ArticleController::class,'store']);
    Route::post('/article/update/{slug}',[ArticleController::class,'update']);
    Route::post('/article/delete/{slug}',[ArticleController::class,'delete']);

    // Route::get('/get-post-comments/{id}',[]);
    // Route::post('/new-comment','');
});