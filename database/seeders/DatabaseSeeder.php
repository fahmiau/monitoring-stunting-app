<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(DataDaerahSeeder::class);
        // $this->call(DataGrafikSeeder::class);
        $kelurahans = [
            Kelurahan::find(3273120003), //Ujung berung
            Kelurahan::find(3273120006), //cigending
            Kelurahan::find(3273120004), //pasirjati
            Kelurahan::find(3273110003), //Pasir biru, cibiru
            Kelurahan::find(3273110004), //Cipadung, cibiru
            Kelurahan::find(3211010002), //sayang,jatinangor, kab sumedang
            Kelurahan::find(3211010006), //jatimukti
            Kelurahan::find(3173010005), //Jakarta pusat, tanah abang, petamburan
        ];
        foreach ($kelurahans as $kelurahan) {
            $this->callWith(MotherSeeder::class,['kelurahan_id' => $kelurahan]);
            $this->callWith(KaderSeeder::class,['kelurahan_id' => $kelurahan]);
            $this->callWith(TenagaKesehatanSeeder::class,['kelurahan_id' => $kelurahan]);
            
        }
        
    }
}