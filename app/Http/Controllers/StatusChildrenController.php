<?php

namespace App\Http\Controllers;

use App\Models\StatusChildren;
use Illuminate\Http\Request;

class StatusChildrenController extends Controller
{
    public function getByProvinsi($id)
    {
        $data = [
            'status_sangat_dibawah' => StatusChildren::where(['provinsi_id'=>$id,'status_stunting'=>'Sangat Dibawah Standar'])->count(),
            'status_dibawah' => StatusChildren::where(['provinsi_id'=>$id,'status_stunting'=>'Dibawah Standar'])->count(),
            'status_normal' => StatusChildren::where(['provinsi_id'=>$id,'status_stunting'=>'Normal'])->count(),
            'status_diatas' => StatusChildren::where(['provinsi_id'=>$id,'status_stunting'=>'Diatas Standar'])->count(),
        ];
        return response($data);
    }

    public function getByKotaKabupaten($id)
    {
        $data = [
            'status_sangat_dibawah' => StatusChildren::where(['kota_kabupaten_id'=>$id,'status_stunting'=>'Sangat Dibawah Standar'])->count(),
            'status_dibawah' => StatusChildren::where(['kota_kabupaten_id'=>$id,'status_stunting'=>'Dibawah Standar'])->count(),
            'status_normal' => StatusChildren::where(['kota_kabupaten_id'=>$id,'status_stunting'=>'Normal'])->count(),
            'status_diatas' => StatusChildren::where(['kota_kabupaten_id'=>$id,'status_stunting'=>'Diatas Standar'])->count(),
        ];
        return response($data);
    }
    
    public function getByKecamatan($id)
    {
        $data = [
            'status_sangat_dibawah' => StatusChildren::where(['kecamatan_id'=>$id,'status_stunting'=>'Sangat Dibawah Standar'])->count(),
            'status_dibawah' => StatusChildren::where(['kecamatan_id'=>$id,'status_stunting'=>'Dibawah Standar'])->count(),
            'status_normal' => StatusChildren::where(['kecamatan_id'=>$id,'status_stunting'=>'Normal'])->count(),
            'status_diatas' => StatusChildren::where(['kecamatan_id'=>$id,'status_stunting'=>'Diatas Standar'])->count(),
        ];
        return response($data);
    }

    public function getByKelurahan($id)
    {
        $data = [
            'status_sangat_dibawah' => StatusChildren::where(['kelurahan_id'=>$id,'status_stunting'=>'Sangat Dibawah Standar'])->count(),
            'status_dibawah' => StatusChildren::where(['kelurahan_id'=>$id,'status_stunting'=>'Dibawah Standar'])->count(),
            'status_normal' => StatusChildren::where(['kelurahan_id'=>$id,'status_stunting'=>'Normal'])->count(),
            'status_diatas' => StatusChildren::where(['kelurahan_id'=>$id,'status_stunting'=>'Diatas Standar'])->count(),
        ];
        return response($data);
    }

    public function update(Request $request)
    {
        $status_children = StatusChildren::where('id',$request->id)
            ->update(['status_stunting' => $request->status_children]);
        return response([
            'data' => $status_children,
            'message' => 'Data Berhasil Diubah'
        ]);
    }

}
