<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provinsi;

class ProvinsiController extends Controller
{
    public function all(){
        $provinsi = Provinsi::all();

        return response()->json($provinsi);
    }

    public function show($id){
        $provinsi = Provinsi::where('id',$id)->first();

        return response()->json($provinsi);
    }
}
