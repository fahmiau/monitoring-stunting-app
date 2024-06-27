<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TempatKerjaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nomor_telepon_kerja' => $this->faker->numerify('############'),
            'alamat_kerja' => $this->faker->address(),
            'tempat_kerja' => $this->faker->randomElement(['Puskesmas','Posyandu'])
        ];
    }
}
