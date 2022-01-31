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
        $kelurahan = KotaKabupaten::all();

        return response()->json($kelurahan);
    }

    public function show($id){
        $kelurahan = Kelurahan::where('id',$id)->first();
                        // ->rightJoin('kecamatans','kelurahans.kecamatan_id','=','kecamatans.id')
                        // ->rightJoin('kota_kabupatens','kecamatans.kota_kabupaten_id','=','kota_kabupatens.id')
                        // ->rightJoin('provinsis','kota_kabupatens.provinsi_id','=','provinsis.id')
                        // ->get();
        // $kelurahan = Kelurahan::where('id',$id)
        //                 // ->join('kecamatans','kelurahans.kecamatan_id','=','kecamatans.id')
        //                 // ->rightJoin('kota_kabupatens','kecamatans.kota_kabupaten_id','=','kota_kabupatens.id')
        //                 // ->rightJoin('provinsis','kota_kabupatens.provinsi_id','=','provinsis.id')
        //                 ->get();

        $kecamatan = Kecamatan::where('id',$kelurahan->kecamatan_id);
        return response()->json($kecamatan);
    }

    public function showByKecamatan($kecamatan_id){
        $kelurahan = Kelurahan::where('kecamatan_id',$kecamatan_id)->get();
        
        return response()->json($kelurahan);
    }
}
