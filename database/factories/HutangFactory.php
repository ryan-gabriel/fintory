<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hutang;
use App\Models\Outlet;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hutang>
 */
class HutangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Hutang::class;

    public function definition()
    {
        $jumlah = $this->faker->randomFloat(2, 100000, 1000000);
        $sisa = $this->faker->randomFloat(2, 0, $jumlah);

        return [
            'outlet_id' => Outlet::factory(),
            'nama_pemberi_hutang' => $this->faker->name,
            'tanggal_hutang' => $this->faker->date(),
            'jumlah' => $jumlah,
            'sisa_hutang' => $sisa,
            'deskripsi' => $this->faker->sentence,
            'created_by' => User::factory(),
        ];
    }
}
