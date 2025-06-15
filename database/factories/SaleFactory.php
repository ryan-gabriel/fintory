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
            // Pilih outlet secara acak
            'outlet_id' => Outlet::inRandomOrder()->first()->id,
            'customer_name' => $this->faker->name(),
            'sale_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'total' => 0, // Total akan di-update nanti setelah item dibuat
            'created_by' => User::first()->id, // Asumsikan user pertama adalah kasir
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Sale $sale) {
            // Setelah record 'sale' utama dibuat, kita buat item-itemnya
            
            $itemsToCreate = rand(1, 4); // Setiap transaksi akan memiliki 1-4 item
            $grandTotal = 0;

            // Ambil produk yang stoknya cukup dari outlet yang sama dengan transaksi
            $products = Product::where('outlet_id', $sale->outlet_id)
                ->where('stok', '>=', 10)
                ->inRandomOrder()
                ->take($itemsToCreate)
                ->get();

            if($products->isEmpty()) {
                // Jika tidak ada produk yang bisa dijual, hapus transaksi yang baru dibuat
                $sale->delete();
                return;
            }

            foreach ($products as $product) {
                $quantity = rand(1, 5); // Kuantitas per produk
                $subtotal = $product->harga_jual * $quantity;
                $grandTotal += $subtotal;

                // 1. Buat SaleItem
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'harga_satuan' => $product->harga_jual,
                    'subtotal' => $subtotal,
                ]);

                // 2. Kurangi stok
                $product->decrement('stok', $quantity);

                // 3. Buat catatan mutasi stok
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

            // 4. Update total harga di record 'sale'
            $sale->update(['total' => $grandTotal]);
        });
    }
}