<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataChildrenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tanggal' => date("Y-m-d"),
            'bulan_ke' => 0,
            'tempat' => 'Rumah',
            'berat_badan' => $this->faker->randomFloat(1,2,5),
            'panjang_badan' => $this->faker->randomFloat(1,42,57)
        ];
    }
}
