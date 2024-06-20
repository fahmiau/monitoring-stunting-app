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

    public function nakesCreate($request,$userId)
    {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:tenaga_kesehatans',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
        ]);
        $validated['user_id'] = $userId;
        $nakes = TenagaKesehatan::create($validated);
        $tempat_kerja = TempatKerja::create([
            'user_id' => $userId,
            'tempat_kerja' => $request->tempat_kerja,
            'nomor_telepon_kerja' => $request->nomor_telepon_kerja,
            'alamat_kerja' => $request->alamat_kerja,
        ]);
        return 'success';
    }

    public function kaderCreate($request, $userId)
    {
        $validated = $request->validate([
            'nik' => 'required|size:16|unique:kaders',
            'provinsi_id' => 'required|exists:App\Models\Provinsi,id',
            'kota_kabupaten_id' => 'required|exists:App\Models\KotaKabupaten,id',
            'kecamatan_id' => 'required|exists:App\Models\Kecamatan,id',
            'kelurahan_id' => 'required|exists:App\Models\Kelurahan,id',
            'alamat' => 'required|max:255',
            'nomor_telepon' => 'required|max:15',
        ]);
        $validated['user_id'] = $userId;
        $kader = Kader::create($validated);
        return 'success';
    }

    public function motherCreate($request,$userId)
    {
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
        $validated['user_id'] = $userId;
        $validated['nama'] = $request->name;
        $mother = Mother::create($validated);
        return 'success';
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6|max:255|confirmed'
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        if (isset($request->category)) {
            $role = Role::create([
                'user_id' => $user->id,
                'category' => $request->category,
            ]);
            $token = '';
            switch ($request->category) {
                case 'User':
                    $mother = $this->motherCreate($request,$user->id);
                    break;
                case 'Kader':
                    $kader = $this->kaderCreate($request,$user->id);
                    break;
                case 'Perawat':
                case 'Bidan':
                    $nakes = $this->nakesCreate($request,$user->id);
                    break;
                case 'Admin':
                    break;
                default:
                    break;
            }
        } else {
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
