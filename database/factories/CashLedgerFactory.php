<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CashLedger;
use App\Models\Outlet;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashLedger>
 */
class CashLedgerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tipe = ['INCOME','EXPENSE','TRANSFER_IN','TRANSFER_OUT'];

        return [
            'outlet_id' => Outlet::factory(),
            'tanggal' => $this->faker->date(),
            'tipe' => $this->faker->randomElement($tipe),
            'sumber' => $this->faker->word,
            'referensi_id' => null,
            'deskripsi' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'saldo_setelah' => $this->faker->randomFloat(2, 1000, 1000000),
            'created_by' => User::factory(),
        ];
    }
}
