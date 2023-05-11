<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceDone>
 */
class ServiceDoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tanggal'  => $this->faker->date(),
            'serialnumber'  => $this->faker->serialnumber(),
            'pelanggan'  => $this->faker->pelanggan(),
            'model'  => $this->faker->model(),
            'ram'  => $this->faker->ram(),
            'android'  => $this->faker->android(),
            'garansi'  => $this->faker->garansi(),
            'kerusakan'  => $this->faker->kerusakan(),
            'teknisi'  => $this->faker->teknisi(),
            'perbaikan'  => $this->faker->perbaikan(),
            'snkanibal'  => $this->faker->snkanibal(),
            'nosparepart'  => $this->faker->nosparepart(),
            'note'  => $this->faker->note(),
        ];
    }
}
