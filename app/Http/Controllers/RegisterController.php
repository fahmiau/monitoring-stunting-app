<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Mother;
use App\Models\TenagaKesehatan;
use App\Models\Kader;
use App\Models\TempatKerja;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\MotherController;


class RegisterController extends Controller
{

    // protected $MotherController;
    // public function __construct(MotherController $MotherController)
    // {
    //     $this->MotherController = $MotherController;
        
    // }

    public function nakesCreate($validated,$user_id)
    {
        
        $validated['user_id'] = $user_id;
        $nakes = TenagaKesehatan::create($validated);
        $tempat_kerja = TempatKerja::create([
            'user_id' => $user_id,
            'tempat_kerja' => $validated['tempat_kerja'],
            'nomor_telepon_kerja' => $validated['nomor_telepon_kerja'],
            'alamat_kerja' => $validated['alamat_kerja'],
        ]);
        return 'success';
    }

    public function kaderCreate($validated,$user_id)
    {
        
        $validated['user_id'] = $user_id;
        $kader = Kader::create($validated);
        return 'success';
    }

    public function motherCreate($validated,$user_id,$user_name)
    {
        
        $validated['user_id'] = $user_id;
        $validated['nama'] = $user_name;
        $mother = Mother::create($validated);
        return 'success';
    }

    function motherValidate($request) {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:mothers',
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
        return $validated;
    }

    function nakesValidate($request) {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:tenaga_kesehatans',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
            'tempat_kerja' => 'required',
            'nomor_telepon_kerja' => 'required',
            'alamat_kerja' => 'required',
        ]);
        return $validated;
    }
    function kaderValidate($request) {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:kaders',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
        ]);
        return $validated;
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:255|confirmed'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        if (isset($request->category)) {
            switch ($request->category) {
                case 'User':
                    $data = $this->motherValidate($request);
                    $user = User::create($validated);
                    $mother = $this->motherCreate($data,$user->id,$user->name);
                    break;
                case 'Kader':
                    $data = $this->kaderValidate($request);
                    $user = User::create($validated);
                    $kader = $this->kaderCreate($data,$user->id);
                    break;
                case 'Perawat':
                case 'Bidan':
                    $data = $this->nakesValidate($request);
                    $user = User::create($validated);
                    $nakes = $this->nakesCreate($data,$user->id);
                    break;
                case 'Admin':
                    break;
                default:
                    break;
            }
            $role = Role::create([
                'user_id' => $user->id,
                'category' => $request->category,
            ]);
            $token = '';
        } else {
            $user = User::create($validated);
            $role = Role::create([
                'user_id' => $user->id,
                'category' => 'User',
            ]);
            $token = $user->createToken('apptoken')->plainTextToken;
        }
        $user->sendEmailVerificationNotification();
        // event(new Registered($user));
        Auth::login($user);
        $response = [
            'user' => $user,
            'role' => $role,
            'token' => $token
        ];
                
        return response($response,201);

    }
}
