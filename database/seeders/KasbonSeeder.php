<?php

namespace Database\Seeders;

use App\Models\Kasbon;
use App\Models\Pegawai;
use Faker\Factory;
use Illuminate\Database\Seeder;

class KasbonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id');
        foreach(Pegawai::all() as $pegawai) {
            Kasbon::create([
                'tanggal_diajukan'  => $faker->dateTimeBetween('-2 months'),
                'pegawai_id'        => $pegawai->id,
                'total_kasbon'      => ($pegawai->total_gaji / 100) * 30
            ]);
        }
    }
}
