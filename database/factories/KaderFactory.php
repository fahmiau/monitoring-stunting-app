<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KaderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nik' => $this->faker->unique()->nik(),
            'alamat' => $this->faker->address(),
            'nomor_telepon' => $this->faker->numerify('############'),
        ];
    }
}
