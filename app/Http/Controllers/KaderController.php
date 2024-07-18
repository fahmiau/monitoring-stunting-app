<?php

namespace App\Http\Controllers;

use App\Models\Kader;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KaderController extends Controller
{
    public function index()
    {
        $data = Kader::join('roles','kaders.user_id','=','roles.user_id')
            ->join('users','kaders.user_id','=','users.id')
            ->join('kecamatans','kaders.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','kaders.kelurahan_id','=','kelurahans.id')
            ->select('kaders.*','roles.category','users.name as name','kecamatans.kecamatan','kelurahans.kelurahan')
            ->get();

        return response($data);
    }

    public function getKaderByProvinsi($provinsi_id)
    {
        $data = Kader::where('kaders.provinsi_id',$provinsi_id)
            ->join('roles','kaders.user_id','=','roles.user_id')
            ->join('users','kaders.user_id','=','users.id')
            ->join('kecamatans','kaders.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','kaders.kelurahan_id','=','kelurahans.id')
            ->select('kaders.*','roles.category','users.name as name','kecamatans.kecamatan','kelurahans.kelurahan')
            ->orderBy('created_at', 'desc')
            ->get();
        
            return response($data);
    }
    
    public function getKaderByKotaKab($kota_kabupaten_id)
    {
        $data = Kader::where('kaders.kota_kabupaten_id',$kota_kabupaten_id)
            ->leftjoin('kecamatans','kecamatans.id','=','kaders.kecamatan_id')
            ->leftjoin('kelurahans','kelurahans.id','=','kaders.kelurahan_id')
            ->join('roles','kaders.user_id','=','roles.user_id')
            ->join('users','kaders.user_id','=','users.id')
            ->select('kecamatans.kecamatan','kelurahans.kelurahan','kaders.*','roles.category','users.name as name')
            ->orderBy('created_at', 'desc')
            ->get();
        
            return response($data);
    }


    public function getKaderByKecamatan($kecamatan_id)
    {
        $data = Kader::where('kaders.kecamatan_id',$kecamatan_id)
            ->join('roles','kaders.user_id','=','roles.user_id')
            ->join('users','kaders.user_id','=','users.id')
            ->join('kecamatans','kaders.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','kaders.kelurahan_id','=','kelurahans.id')
            ->select('kaders.*','roles.category','users.name as name','kecamatans.kecamatan','kelurahans.kelurahan')
            ->orderBy('created_at', 'desc')
            ->get();
        
            return response($data);
    }


    public function getKaderByKelurahan($kelurahan_id)
    {
        $data = Kader::where('kaders.kelurahan_id',$kelurahan_id)
            ->join('roles','kaders.user_id','=','roles.user_id')
            ->join('users','kaders.user_id','=','users.id')
            ->join('kecamatans','kaders.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','kaders.kelurahan_id','=','kelurahans.id')
            ->select('kaders.*','roles.category','users.name as name','kecamatans.kecamatan','kelurahans.kelurahan')
            ->orderBy('created_at', 'desc')
            ->get();
            return response($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'nik' => 'required|unique:tenaga_kesehatans|size:16',
            'kelurahan_id' => 'required|exists:\App\Models\Kelurahan,id',
            'kecamatan_id' => 'required|exists:\App\Models\Kecamatan,id',
            'kota_kabupaten_id' => 'required|exists:\App\Models\KotaKabupaten,id',
            'provinsi_id' => 'required|exists:\App\Models\Provinsi,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15|numeric',
        ]);

        $kader = Kader::create($validated);
        $kelurahan = Kelurahan::where('id',$kader->kelurahan_id)->first();
        $data_alamat = [
            'kelurahan' => $kelurahan->kelurahan,
            'kecamatan' => $kelurahan->kecamatan->kecamatan,
            'kota_kabupaten' => $kelurahan->kecamatan->kotaKabupaten->kota_kabupaten,
            'provinsi' => $kelurahan->kecamatan->kotaKabupaten->provinsi->provinsi,
        ];
        $response = [
            'data' => $kader,
            'data_alamat' => $data_alamat
        ];
        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kader = Kader::find($id);
        return response($kader);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kader = Kader::find($id);
        if ($kader == null) {
            return response(['message' => 'Kader Tidak Ada']);
        }
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'kelurahan_id' => 'required|exists:\App\Models\Kelurahan,id',
            'kecamatan_id' => 'required|exists:\App\Models\Kecamatan,id',
            'kota_kabupaten_id' => 'required|exists:\App\Models\KotaKabupaten,id',
            'provinsi_id' => 'required|exists:\App\Models\Provinsi,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
        ]);

        $kader->update($validated);
        $kader['nama'] = $kader->user->name;
        return response ($kader);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getByKelurahan($kelurahan_id)
    {
        $kader = Kader::where('kelurahan_id',$kelurahan_id)->with('user')->get();
        return response($kader);
    }
    
    public function getByKecamatan($kecamatan_id)
    {
        $kader = Kader::where('kecamatan_id',$kecamatan_id)->with('user')->get();
        return response($kader);
    }

    public function getByKotaKabupaten($kota_kabupaten_id)
    {
        $kader = Kader::where('kota_kabupaten_id',$kota_kabupaten_id)->with('user')->get();
        return response($kader);
    }

    public function getByProvinsi($provinsi_id)
    {
        $kader = Kader::where('provinsi_id',$provinsi_id)->with('user')->get();
        return response($kader);
    }

    public function getKaderbyKaderId($kader_id)
    {
        $kader = Kader::where('id',$kader_id)->with('user.role')->first();
        return response($kader);
    }

    public function destroy($id)
    {
        $kader = Kader::find($id);
        $kader->delete();
        $response = ['message' => 'Data Kader Berhasil Dihapus'];
        return response($response);
    }

}
