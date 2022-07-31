<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use Illuminate\Http\Request;
use App\Models\KotaKabupaten;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Role;
use App\Models\TenagaKesehatan;
use App\Models\User;

class KelurahanController extends Controller
{
    public function all(){
        $kelurahan = Kelurahan::all();

        return response()->json($kelurahan);
    }

    public function show($id){
        $kelurahan = Kelurahan::where('id',$id)->first();
        $data_daerah = [
            'kelurahan_id' => $kelurahan->id,
            'kelurahan' => $kelurahan->kelurahan,
            'kecamatan_id' => $kelurahan->kecamatan->id,
            'kecamatan' => $kelurahan->kecamatan->kecamatan,
            'kota_kabupaten_id' => $kelurahan->kecamatan->kotaKabupaten->id,
            'kota_kabupaten' => $kelurahan->kecamatan->kotaKabupaten->kota_kabupaten,
            'provinsi_id' => $kelurahan->kecamatan->kotaKabupaten->provinsi->id,
            'provinsi' => $kelurahan->kecamatan->kotaKabupaten->provinsi->provinsi,
        ];
        return response($data_daerah);
    }

    public function showByKecamatan($kecamatan_id){
        $kelurahan = Kelurahan::where('kecamatan_id',$kecamatan_id)->get();
        
        return response($kelurahan);
    }

    public function showByUserId($user_id)
    {
        $user = User::find($user_id);

        
        switch ($user->role->category) {
            case 'Perawat':
            case 'Bidan';
                $data_daerah = TenagaKesehatan::where('user_id',$user_id)->first(['kelurahan_id','kecamatan_id','kota_kabupaten_id','provinsi_id']);
                break;
            case 'Kader';
                $data_daerah = Kader::where('user_id',$user_id)->first(['kelurahan_id','kecamatan_id','kota_kabupaten_id','provinsi_id']);
            default:
                return response('Tidak ada data Kelurahan untuk user id '.$user_id);
                break;
        }
        return response($data_daerah);
    }
}
