<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaKabupaten;
use App\Models\Provinsi;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function all(){
        $kecamatan = KotaKabupaten::all();

        return response()->json($kecamatan);
    }

    public function show($id){
        $kecamatan = Kecamatan::where('id',$id)->first()
                        ->join('kota_kabupatens','kota_kabupatens.id','=','kecamatans.kota_kabupaten_id')
                        ->join('provinsis','provinsis.id','=','kota_kabupatens.provinsi_id')
                        ->get();

        return response()->json($kecamatan);
    }

    public function showByKotaKabupaten($kota_kabupaten_id){
        $kecamatan = Kecamatan::where('kota_kabupaten_id',$kota_kabupaten_id)->get();
        return response()->json($kecamatan);
    }
}
