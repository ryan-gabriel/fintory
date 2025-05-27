<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cicilan;
use App\Models\Hutang;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cicilan>
 */
class CicilanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Cicilan::class;

    public function definition()
    {
        return [
            'hutang_id' => Hutang::factory(),
            'tanggal_bayar' => $this->faker->date(),
            'jumlah_bayar' => $this->faker->randomFloat(2, 10000, 500000),
            'metode_pembayaran' => $this->faker->randomElement(['Cash', 'Transfer', 'QRIS']),
            'deskripsi' => $this->faker->sentence,
            'created_by' => User::factory(),
        ];
    }
}
