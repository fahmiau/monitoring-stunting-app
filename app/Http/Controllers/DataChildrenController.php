<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\DataChildren;
use App\Models\HeightBoy;
use App\Models\HeightGirl;
use App\Models\StatusChildren;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DataChildrenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'children_id' => 'required|exists:App\Models\Children,id',
            'tanggal' => 'required|date',
            'bulan_ke' => 'required|numeric|min:0',
            'tempat' => 'required|max:20',
            'berat_badan' => 'required|numeric',
            'panjang_badan' => 'required|numeric',
        ]);

        $data_children = DataChildren::create($validated);
        $status_children = ['provinsi_id' => $data_children->children->provinsi_id,
                            'kota_kabupaten_id' => $data_children->children->kota_kabupaten_id,
                            'kecamatan_id' => $data_children->children->kecamatan_id,
                            'kelurahan_id' => $data_children->children->kelurahan_id,
                            'status_stunting' => $this->getStatusStunting($data_children->bulan_ke, $data_children->panjang_badan, $data_children->children->jenis_kelamin),
                            ];
        $store_status_children = StatusChildren::updateOrCreate(
            ['children_id' => $data_children->children_id],
            $status_children);
        // $response = [
        //     'data_children' => $data_children,
        //     'status' => $store_status_children->status_stunting,
        //     'message' => 'success'
        // ];
        return response([
            'data' => $data_children,
            'status' => $store_status_children->status_stunting
        ]);
        // return response($response);
    }

    public function update(Request $request)
    {
        $data_children = DataChildren::find($request->id);
        if ($data_children == null) {
            return response(['message' => 'Data Tidak Ada']);
        }

        $validated = $request->validate([
            'children_id' => 'required|exists:App\Models\Children,id',
            'tanggal' => 'required|date',
            'bulan_ke' => 'required|numeric|min:0',
            'tempat' => 'required|max:20',
            'berat_badan' => 'required|numeric',
            'panjang_badan' => 'required|numeric',
        ]);

        $data_children->update($validated);
        $status_children = ['provinsi_id' => $data_children->children->provinsi_id,
                            'kota_kabupaten_id' => $data_children->children->kota_kabupaten_id,
                            'kecamatan_id' => $data_children->children->kecamatan_id,
                            'kelurahan_id' => $data_children->children->kelurahan_id,
                            'status_stunting' => $this->getStatusStunting($data_children->bulan_ke, $data_children->panjang_badan, $data_children->children->jenis_kelamin),
                            ];
        $store_status_children = StatusChildren::updateOrCreate(
            ['children_id' => $data_children->children_id],
            $status_children);
        return response([
            'data' => $data_children,
            'status' => $store_status_children->status_stunting
        ]);
    }

    public function getStatusStunting($month, $height, $gender)
    {
        if ($gender == 'Laki-Laki') {
            $hData = HeightBoy::where('months', $month)->first();
        } else {
            $hData = HeightGirl::where('months', $month)->first();
        }
        switch (true) {
            case $height < $hData->negative_3sd:
                return 'Sangat Dibawah Standar';
                break;
            case ($height >= $hData->negative_3sd && $height < $hData->negative_2sd):
                return 'Dibawah Standar';
                break;
            case ($height >= $hData->negative_2sd && $height <= $hData->positive_3sd):
                return 'Normal';
                break;
            case $height > $hData->positive_3sd:
                return 'Diatas Standar';
                break;
            default:
                # code...
                break;
        }
    }

    public function getByChild($children_id)
    {
        $children = Children::find($children_id);
        $children->dataChildrens;
        $children->statusChildren;
        $children->mother;
        return response([
            'data' => $children,
            'message' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $data = DataChildren::find($id);
        $result = $data->delete();
        if ($result) {
            return response(['message' => 'Data Berhasil Dihapus']);
        } else {
            return response(['message' => 'Data Gagal Dihapus']);
        }
    }
}
