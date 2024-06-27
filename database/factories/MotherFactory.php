<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MotherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name($gender = 'female'),
            'nik' => $this->faker->unique()->nik(),
            'pekerjaan' => $this->faker->jobTitle(),
            'alamat' => $this->faker->address(),
            'nomor_telepon' => $this->faker->numerify('############'),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
            'golongan_darah' => $this->faker->randomElement(['A','B','AB','O']),
            'pendidikan' => $this->faker->randomElement(['S1','S2','S3','SMA','D3'])
        ];
    }
}
