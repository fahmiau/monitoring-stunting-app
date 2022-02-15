<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KotaKabupaten;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class KelurahanController extends Controller
{
    public function all(){
        $kelurahan = Kelurahan::all();

        return response()->json($kelurahan);
    }

    public function show($id){
        $kelurahan = Kelurahan::where('id',$id)->first();
        $data_daerah = [
            'kelurahan' => $kelurahan->kelurahan,
            'kecamatan' => $kelurahan->kecamatan->kecamatan,
            'kota_kabupaten' => $kelurahan->kecamatan->kotaKabupaten->kota_kabupaten,
            'provinsi' => $kelurahan->kecamatan->kotaKabupaten->provinsi->provinsi,
        ];
        return response($data_daerah);
    }

    public function showByKecamatan($kecamatan_id){
        $kelurahan = Kelurahan::where('kecamatan_id',$kecamatan_id)->get();
        
        return response($kelurahan);
    }
}
