<?php

namespace Database\Factories;

use App\Models\Outlet;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMutation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        return [
            'outlet_id' => Outlet::inRandomOrder()->first()->id,
            'customer_name' => $this->faker->name(),
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total' => 0,
            'created_by' => User::first()->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Sale $sale) {

            // 🎯 TARGET TOTAL TRANSAKSI
            $targetTotal = rand(300_000, 600_000);

            $grandTotal = 0;

            // Ambil produk dari outlet yang sama
            $products = Product::where('outlet_id', $sale->outlet_id)
                ->where('stok', '>=', 5)
                ->inRandomOrder()
                ->get();

            if ($products->isEmpty()) {
                $sale->delete();
                return;
            }

            foreach ($products as $product) {
                if ($grandTotal >= $targetTotal) {
                    break;
                }

                $remaining = $targetTotal - $grandTotal;

                // Hitung quantity agar mendekati target
                $maxQtyByPrice = floor($remaining / $product->harga_jual);
                $maxQtyByStock = min($product->stok, 5);

                $quantity = max(1, min($maxQtyByPrice, $maxQtyByStock));

                if ($quantity <= 0) {
                    continue;
                }

                $subtotal = $product->harga_jual * $quantity;
                $grandTotal += $subtotal;

                // 1️⃣ SaleItem
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'harga_satuan' => $product->harga_jual,
                    'subtotal' => $subtotal,
                ]);

                // 2️⃣ Kurangi stok
                $product->decrement('stok', $quantity);

                // 3️⃣ Stock mutation
                StockMutation::create([
                    'product_id' => $product->id,
                    'outlet_id' => $sale->outlet_id,
                    'quantity' => $quantity,
                    'type' => 'out',
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'created_at' => $sale->sale_date,
                    'updated_at' => $sale->sale_date,
                ]);
            }

            // 🛡️ SAFETY: kalau masih kurang, jangan simpan
            if ($grandTotal < 300_000) {
                $sale->delete();
                return;
            }

            // 4️⃣ Update total
            $sale->update(['total' => $grandTotal]);
        });
    }
}
