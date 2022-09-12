<?php

namespace Database\Seeders;

use App\Models\HeightBoy;
use App\Models\WeightBoy;
use App\Models\HeightGirl;
use App\Models\WeightGirl;
use Illuminate\Database\Seeder;

class DataGrafikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $weight_boy = fopen(base_path("seeder-data/data-grafik/weightboys.csv"), "r");

        while (($data = fgetcsv($weight_boy, 100, ",")) !== FALSE) {
            WeightBoy::create([
                'id' => $data[0],
                'months' => $data[1],
                'negative_3sd' => $data[2],
                'negative_2sd' => $data[3],
                'negative_1sd' => $data[4],
                'median' => $data[5],
                'positive_1sd' => $data[6],
                'positive_2sd' => $data[7],
                'positive_3sd' => $data[8],
            ]);  
        }

        fclose($weight_boy);

        $height_boy = fopen(base_path("seeder-data/data-grafik/heightboys.csv"), "r");

        while (($data = fgetcsv($height_boy, 100, ",")) !== FALSE) {
            HeightBoy::create([
                'id' => $data[0],
                'months' => $data[1],
                'negative_3sd' => $data[2],
                'negative_2sd' => $data[3],
                'negative_1sd' => $data[4],
                'median' => $data[5],
                'positive_1sd' => $data[6],
                'positive_2sd' => $data[7],
                'positive_3sd' => $data[8],
            ]);  
        }

        fclose($height_boy);

        $weight_girl = fopen(base_path("seeder-data/data-grafik/weightgirls.csv"), "r");

        while (($data = fgetcsv($weight_girl, 100, ",")) !== FALSE) {
            WeightGirl::create([
                'id' => $data[0],
                'months' => $data[1],
                'negative_3sd' => $data[2],
                'negative_2sd' => $data[3],
                'negative_1sd' => $data[4],
                'median' => $data[5],
                'positive_1sd' => $data[6],
                'positive_2sd' => $data[7],
                'positive_3sd' => $data[8],
            ]);  
        }

        fclose($weight_girl);

        $height_girl = fopen(base_path("seeder-data/data-grafik/heightgirls.csv"), "r");

        while (($data = fgetcsv($height_girl, 100, ",")) !== FALSE) {
            HeightGirl::create([
                'id' => $data[0],
                'months' => $data[1],
                'negative_3sd' => $data[2],
                'negative_2sd' => $data[3],
                'negative_1sd' => $data[4],
                'median' => $data[5],
                'positive_1sd' => $data[6],
                'positive_2sd' => $data[7],
                'positive_3sd' => $data[8],
            ]);  
        }

        fclose($height_girl);
    }
}
