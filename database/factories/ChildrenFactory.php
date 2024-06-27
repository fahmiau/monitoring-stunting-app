<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChildrenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'jenis_kelamin' => $this->faker->randomElement(['Perempuan','Laki-laki']),
            'nik' => $this->faker->unique()->nik(),
            'no_akta' => $this->faker->bothify('##/??/#####/#####'),
            'alamat' => $this->faker->address(),
            'tempat_lahir' => $this->faker->city(),
            'tanggal_lahir' => $this->faker->date(),
        ];
    }
}
