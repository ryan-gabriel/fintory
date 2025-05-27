<?php

namespace Database\Seeders;
use App\Models\Outlet;
use App\Models\User;
use App\Models\OutletBalance;
use App\Models\CashLedger;
use App\Models\Hutang;
use App\Models\Cicilan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::firstOrCreate(['id' => 1], [
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);

        // Buat 20 outlet milik user ID 1
        $outlets = Outlet::factory()->count(20)->create([
            'owner_id' => $user->id,
        ]);

        foreach ($outlets as $outlet) {
            // OutletBalance untuk setiap outlet
            OutletBalance::factory()->create([
                'outlet_id' => $outlet->id,
            ]);

            // 3 transaksi cash ledger per outlet
            CashLedger::factory()->count(3)->create([
                'outlet_id' => $outlet->id,
                'created_by' => $user->id,
            ]);

            // 1 hutang per outlet
            $hutang = Hutang::factory()->create([
                'outlet_id' => $outlet->id,
                'created_by' => $user->id,
            ]);

            // 2 cicilan per hutang
            Cicilan::factory()->count(2)->create([
                'hutang_id' => $hutang->id,
                'created_by' => $user->id,
            ]);
        }
    }
}
