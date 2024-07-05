<?php

namespace Database\Seeders;

use App\Models\Children;
use App\Models\DataChildren;
use App\Models\Kelurahan;
use App\Models\Role;
use App\Models\StatusChildren;
use App\Models\User;
use Illuminate\Database\Seeder;

class MotherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($kelurahan_id)
    {
        // $kelurahan_id = Kelurahan::find(3273120003);
        // $kelurahan_id = $kelurahan->id;
        $users = User::factory(5)
            ->hasMothers([
                'kelurahan_id' => $kelurahan_id->id,
                'kecamatan_id' => $kelurahan_id->kecamatan->id,
                'kota_kabupaten_id' => $kelurahan_id->kecamatan->kotaKabupaten->id,
                'provinsi_id' => $kelurahan_id->kecamatan->kotaKabupaten->provinsi->id
            ])->create();
        foreach ($users as $user) {
            $mother = $user->mothers()->first();
            $role = Role::create([
                'user_id' => $user->id,
                'category' => 'User'
            ]);
            $children = Children::factory()
                ->for($mother)
                ->create([
                    'jenis_kelamin' => 'Perempuan',
                    'anak_ke' => 1,
                    'kelurahan_id' => $kelurahan_id->id,
                    'kecamatan_id' => $kelurahan_id->kecamatan->id,
                    'kota_kabupaten_id' => $kelurahan_id->kecamatan->kotaKabupaten->id,
                    'provinsi_id' => $kelurahan_id->kecamatan->kotaKabupaten->provinsi->id
                ]);
            $data_children = DataChildren::factory()
                ->for($children)
                ->create();
            $status = '';
            switch (true) {
                case $data_children->panjang_badan < 44.2:
                    $status = 'Sangat Dibawah Standar';
                    break;
                    case ($data_children->panjang_badan >= 44.2 && $data_children->panjang_badan < 46.1):
                    $status = 'Dibawah Standar';
                    break;
                case ($data_children->panjang_badan >= 46.1 && $data_children->panjang_badan <= 55.6):
                    $status = 'Normal';
                    break;
                case $data_children->panjang_badan > 55.6:
                    $status = 'Diatas Standar';
                    break;
                default:
                # code...
                break;
            }
            $status_children = StatusChildren::create([
                'children_id' => $children->id,
                'kelurahan_id' => $kelurahan_id->id,
                'kecamatan_id' => $kelurahan_id->kecamatan->id,
                'kota_kabupaten_id' => $kelurahan_id->kecamatan->kotaKabupaten->id,
                'provinsi_id' => $kelurahan_id->kecamatan->kotaKabupaten->provinsi->id,
                'status_stunting' => $status
            ]);
        }
    }
}
