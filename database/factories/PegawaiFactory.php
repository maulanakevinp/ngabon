<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama'          => substr($this->faker->name(),0,10),
            'tanggal_masuk' => $this->faker->dateTimeBetween('-10 years'),
            'total_gaji'    => round(rand(2000000, 5000000), -3)
        ];
    }
}
