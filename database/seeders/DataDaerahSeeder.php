<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\KotaKabupaten;
use App\Models\Provinsi;
use Illuminate\Database\Seeder;

class DataDaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $provinsi = fopen(base_path("seeder-data/data-daerah/provinces.csv"), "r");

        while (($data = fgetcsv($provinsi, 100, ",")) !== FALSE) {
            Provinsi::create([
                'id' => $data[0],
                'provinsi' => $data[1]
            ]);  
        }

        fclose($provinsi);
        
        $kota_kabupaten = fopen(base_path("seeder-data/data-daerah/regencies.csv"), "r");

        while (($data = fgetcsv($kota_kabupaten, 1000, ",")) !== FALSE) {
            KotaKabupaten::create([
                'id' => $data[0],
                'provinsi_id' => $data[1],
                'kota_kabupaten' => $data[2]
            ]);  
        }

        fclose($kota_kabupaten);

        $kecamatan = fopen(base_path("seeder-data/data-daerah/districts.csv"), "r");

        while (($data = fgetcsv($kecamatan, 8000, ",")) !== FALSE) {
            Kecamatan::create([
                'id' => $data[0],
                'kota_kabupaten_id' => $data[1],
                'kecamatan' => $data[2]
            ]);  
        }

        fclose($kecamatan);

        $kelurahan = fopen(base_path("seeder-data/data-daerah/villages.csv"), "r");

        while (($data = fgetcsv($kelurahan, 82000, ",")) !== FALSE) {
            Kelurahan::create([
                'id' => $data[0],
                'kecamatan_id' => $data[1],
                'kelurahan' => $data[2]
            ]);  
        }

        fclose($kelurahan);

    }
}
