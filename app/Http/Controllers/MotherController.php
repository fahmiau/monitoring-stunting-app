<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\Mother;
use Illuminate\Http\Request;

class MotherController extends Controller
{
    public function index()
    {
        $data = Mother::with('childrens')->get();
        return response($data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'nama' => 'required|max:100',
            'nik' => 'required|unique:mothers|size:16',
            'golongan_darah' => 'required',
            'pendidikan' => 'required|max:5',
            'pekerjaan' => 'required|max:20',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
            'tempat_lahir' => 'required|max:15',
            'tanggal_lahir' => 'required|date',
        ]);

        $mother = Mother::create($validated);
        $kelurahan = Kelurahan::where('id',$mother->kelurahan_id)->first();
        $data_alamat = [
            'kelurahan' => $kelurahan->kelurahan,
            'kecamatan' => $kelurahan->kecamatan->kecamatan,
            'kota_kabupaten' => $kelurahan->kecamatan->kotaKabupaten->kota_kabupaten,
            'provinsi' => $kelurahan->kecamatan->kotaKabupaten->provinsi->provinsi,
        ];

        $response = [
            'mother' => [
                'data' => $mother,
                'data_alamat' => $data_alamat
            ],
            'message' => 'Data Ibu Telah Tersimpan'
        ];

        return response($response);
    }

    public function update(Request $request, $id)
    {
        $mother = Mother::find($id);
        if ($mother == null) {
            return response(['message' => 'Data Ibu Tidak Ada']);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'nama' => 'required|max:100',
            'golongan_darah' => 'required',
            'pendidikan' => 'required|max:5',
            'pekerjaan' => 'required|max:20',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
            'tempat_lahir' => 'required|max:15',
            'tanggal_lahir' => 'required|date',
        ]);

        $mother->update($validated);
        $response = [
            'data' => $mother,
            'message' => 'Data Berhasil Diubah'
        ];

        return response($response);
    }

    public function destroy($id)
    {
        $response = [
            'data' => Mother::destroy($id),
            'message' => 'Data Ibu Berhasil Dihapus'
        ];

        return response($response);
    }
}
