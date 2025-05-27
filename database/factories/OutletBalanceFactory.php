<?php

namespace Database\Factories;

use App\Models\OutletBalance;
use App\Models\Outlet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutletBalance>
 */
class OutletBalanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'outlet_id' => Outlet::factory(),
            'saldo' => $this->faker->randomFloat(2, 10000, 1000000),
            'last_updated' => now(),
        ];
    }
}
