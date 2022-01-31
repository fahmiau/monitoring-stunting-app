<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaKabupaten;
use App\Models\Provinsi;

class KotaKabupatenController extends Controller
{
    public function all(){
        $kota_kabupaten = KotaKabupaten::all();

        return response()->json($kota_kabupaten);
    }

    public function show($id){
        $kota_kabupaten = KotaKabupaten::where('id',$id)->first()
                        ->join('provinsis','provinsis.id','=','kota_kabupatens.provinsi_id')
                        ->get();

        return response()->json($kecamatan);
    }

    public function showByProvinsi($provinsi_id){
        $kota_kabupaten = KotaKabupaten::where('provinsi_id',$provinsi_id)->get();
        return response()->json($kota_kabupaten);
    }
}
