<?php

namespace App\Http\Controllers;

use App\Models\Children;
use App\Models\Kelurahan;
use App\Models\StatusChildren;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChildrenController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mother_id' => 'required|exists:App\Models\Mother,id',
            'nama' => 'required|max:100',
            'jenis_kelamin' => 'required',
            'no_akta' => 'required|unique:childrens|size:21',
            'anak_ke' => 'required|numeric|min:1',
            'nik' => 'required|unique:childrens|size:16',
            'alamat' => 'required|max:255',
            'tempat_lahir' => 'required|max:15',
            'tanggal_lahir' => 'required|date',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
        ]);

        $children = Children::create($validated);
        $kelurahan = Kelurahan::where('id',$children->kelurahan_id)->first();
        $data_alamat = [
            'kelurahan' => $kelurahan->kelurahan,
            'kecamatan' => $kelurahan->kecamatan->kecamatan,
            'kota_kabupaten' => $kelurahan->kecamatan->kotaKabupaten->kota_kabupaten,
            'provinsi' => $kelurahan->kecamatan->kotaKabupaten->provinsi->provinsi,
        ];

        $response = [
            'children' => [
                'data' => $children,
                'data_alamat' => $data_alamat
            ],
            'message' => 'Data Anak Telah Tersimpan'
        ];

        return response($response);
    }

    public function getAllChildren()
    {
        $children = StatusChildren::with('children.mother')->get();
        
        return $children;
    }

    public function getChildrenById($id)
    {
        $children = Children::where('id',$id)->with(['dataChildrens','statusChildren'])->first();

        return $children;
    }

    public function getChildrenByMotherId($mother_id)
    {
        $children = Children::where('mother_id',$mother_id)->with(['dataChildrens','statusChildren'])->first();

        return $children;
    }
    
}
