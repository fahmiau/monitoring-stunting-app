<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class KaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($kelurahan_id)
    {
        $users = User::factory(3)
            ->hasKader([
                'kelurahan_id' => $kelurahan_id->id,
                'kecamatan_id' => $kelurahan_id->kecamatan->id,
                'kota_kabupaten_id' => $kelurahan_id->kecamatan->kotaKabupaten->id,
                'provinsi_id' => $kelurahan_id->kecamatan->kotaKabupaten->provinsi->id
            ])
            ->create();
    }
}
