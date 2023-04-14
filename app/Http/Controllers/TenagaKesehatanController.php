<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\TempatKerja;
use Illuminate\Http\Request;
use App\Models\TenagaKesehatan;
use App\Models\User;

class TenagaKesehatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TenagaKesehatan::join('roles','tenaga_kesehatans.user_id','=','roles.user_id')
            ->join('tempat_kerjas','tenaga_kesehatans.user_id','=','tempat_kerjas.user_id')
            ->join('users','tenaga_kesehatans.user_id','=','users.id')
            ->join('kecamatans','tenaga_kesehatans.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','tenaga_kesehatans.kelurahan_id','=','kelurahans.id')
            ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email','kecamatans.kecamatan','kelurahans.kelurahan')
            ->get();

        return response($data);
    }

    public function getNakesByProvinsi($provinsi_id)
    {
        $data = TenagaKesehatan::where('tenaga_kesehatans.provinsi_id',$provinsi_id)
            ->join('roles','tenaga_kesehatans.user_id','=','roles.user_id')
            ->join('tempat_kerjas','tenaga_kesehatans.user_id','=','tempat_kerjas.user_id')
            ->join('users','tenaga_kesehatans.user_id','=','users.id')
            ->join('kecamatans','tenaga_kesehatans.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','tenaga_kesehatans.kelurahan_id','=','kelurahans.id')
            ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email','kecamatans.kecamatan','kelurahans.kelurahan')
            ->get();
        
            return response($data);
    }
    
    public function getNakesByKotaKab($kota_kabupaten_id)
    {
        $data = TenagaKesehatan::where('tenaga_kesehatans.kota_kabupaten_id',$kota_kabupaten_id)
            ->join('roles','tenaga_kesehatans.user_id','=','roles.user_id')
            ->join('tempat_kerjas','tenaga_kesehatans.user_id','=','tempat_kerjas.user_id')
            ->join('users','tenaga_kesehatans.user_id','=','users.id')
            ->join('kecamatans','tenaga_kesehatans.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','tenaga_kesehatans.kelurahan_id','=','kelurahans.id')
            ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email','kecamatans.kecamatan','kelurahans.kelurahan')
            ->get();
        
            return response($data);
    }


    public function getNakesByKecamatan($kecamatan_id)
    {
        $data = TenagaKesehatan::where('tenaga_kesehatans.kecamatan_id',$kecamatan_id)
            ->join('roles','tenaga_kesehatans.user_id','=','roles.user_id')
            ->join('tempat_kerjas','tenaga_kesehatans.user_id','=','tempat_kerjas.user_id')
            ->join('users','tenaga_kesehatans.user_id','=','users.id')
            ->join('kecamatans','tenaga_kesehatans.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','tenaga_kesehatans.kelurahan_id','=','kelurahans.id')
            // ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email')
            ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email','kecamatans.kecamatan','kelurahans.kelurahan')
            ->get();
        
            return response($data);
    }


    public function getNakesByKelurahan($kelurahan_id)
    {
        $data = TenagaKesehatan::where('tenaga_kesehatans.kelurahan_id',$kelurahan_id)
            ->join('roles','tenaga_kesehatans.user_id','=','roles.user_id')
            ->join('tempat_kerjas','tenaga_kesehatans.user_id','=','tempat_kerjas.user_id')
            ->join('users','tenaga_kesehatans.user_id','=','users.id')
            ->join('kecamatans','tenaga_kesehatans.kecamatan_id','=','kecamatans.id')
            ->join('kelurahans','tenaga_kesehatans.kelurahan_id','=','kelurahans.id')
            ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email','kecamatans.kecamatan','kelurahans.kelurahan')
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
            'nomor_telepon' => 'required|max:15',
        ]);

        $nakes = TenagaKesehatan::create($validated);
        $kelurahan = Kelurahan::where('id',$nakes->kelurahan_id)->first();
        $data_alamat = [
            'kelurahan' => $kelurahan->kelurahan,
            'kecamatan' => $kelurahan->kecamatan->kecamatan,
            'kota_kabupaten' => $kelurahan->kecamatan->kotaKabupaten->kota_kabupaten,
            'provinsi' => $kelurahan->kecamatan->kotaKabupaten->provinsi->provinsi,
        ];
        $response = [
            'data' => $nakes,
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
        $nakes = TenagaKesehatan::find($id);
        return response($nakes);
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
        $nakes = TenagaKesehatan::find($id);
        if ($nakes == null) {
            return response(['message' => 'Tenaga Kesehatan Tidak Ada']);
        }
        $validated = $request->validate([
            'user_id' => 'required|exists:App\Models\User,id',
            'kelurahan_id' => 'required|exists:\App\Models\Kelurahan,id',
            'kecamatan_id' => 'required|exists:\App\Models\Kecamatan,id',
            'kota_kabupaten_id' => 'required|exists:\App\Models\KotaKabupaten,id',
            'provinsi_id' => 'required|exists:\App\Models\Provinsi,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
            'tempat_kerja'=> 'required',
            'nomor_telepon_kerja'=> 'required',
            'alamat_kerja'=> 'required'
        ]);
        $nakes->update($validated);
        $nakes['nama'] = $nakes->user->name;
        $tempat_kerja = TempatKerja::where('user_id',$nakes->user_id)->first();
        $tempat_kerja->update($validated);
        return response ($nakes);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getByKelurahan($kelurahan_id)
    {
        $nakes = TenagaKesehatan::where('kelurahan_id',$kelurahan_id)->with('user')->get();
        return response($nakes);
    }
    
    public function getByKecamatan($kecamatan_id)
    {
        $nakes = TenagaKesehatan::where('kecamatan_id',$kecamatan_id)->with('user')->get();
        return response($nakes);
    }

    public function getByKotaKabupaten($kota_kabupaten_id)
    {
        $nakes = TenagaKesehatan::where('kota_kabupaten_id',$kota_kabupaten_id)->with('user')->get();
        return response($nakes);
    }

    public function getByProvinsi($provinsi_id)
    {
        $nakes = TenagaKesehatan::where('provinsi_id',$provinsi_id)->with('user')->get();
        return response($nakes);
    }

    public function getNakesByNakesId($nakes_id)
    {
        // $nakes = TenagaKesehatan::where('id',$nakes_id)
        //     ->join('roles','tenaga_kesehatans.user_id','=','roles.user_id')
        //     ->join('tempat_kerjas','tenaga_kesehatans.user_id','=','tempat_kerjas.user_id')
        //     ->join('users','tenaga_kesehatans.user_id','=','users.id')
        //     ->select('tenaga_kesehatans.*','roles.category','tempat_kerjas.tempat_kerja','users.name','users.email')
        //     ->get();
        $nakes = TenagaKesehatan::where('id',$nakes_id)->with('user.tempat_kerja','user.role')->first();
        return response($nakes);
    }

    public function destroy($id)
    {
        $nakes = TenagaKesehatan::find($id);
        $user = User::where('id',$nakes['user_id'])->first();
        $tempat_kerja = TempatKerja::where('user_id',$nakes['user_id'])->first();
        $nakes->delete();
        $tempat_kerja->delete();
        $user->delete();
        $response = ['message' => 'Data Nakes Berhasil Dihapus'];
        return response($response);
    }

}
