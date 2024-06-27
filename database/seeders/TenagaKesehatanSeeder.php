<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TenagaKesehatan;
use App\Models\User;
use App\Models\Kelurahan;
use App\Models\Role;
use App\Models\TempatKerja;

class TenagaKesehatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($kelurahan_id)
    {

        $users = User::factory(3)
            ->hasNakes([
                'kelurahan_id' => $kelurahan_id->id,
                'kecamatan_id' => $kelurahan_id->kecamatan->id,
                'kota_kabupaten_id' => $kelurahan_id->kecamatan->kotaKabupaten->id,
                'provinsi_id' => $kelurahan_id->kecamatan->kotaKabupaten->provinsi->id
            ])
            ->hasTempatKerja()
            ->hasRole()
            ->create();
    }
}
