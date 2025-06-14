<?php

namespace App\Livewire\Penjualan;

use App\Models\Outlet;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMutation;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PosForm extends Component
{
    // Properti untuk data form
    public $outlets = [];
    public $products = [];
    public $customer_name = 'Customer';
    public $selectedOutlet;

    // Properti untuk keranjang belanja
    public $cart = [];
    public $grandTotal = 0;

    // Properti untuk pencarian produk
    public $searchQuery = '';
    public $searchResults = [];

    public function mount()
    {
        // Muat outlet saat komponen pertama kali dimuat
        $lembaga_id = session('current_lembaga_id');
        $this->outlets = Outlet::where('lembaga_id', $lembaga_id)->get();
    }

    // Dipanggil setiap kali $searchQuery berubah
    public function updatedSearchQuery()
    {
        if (strlen($this->searchQuery) >= 2 && $this->selectedOutlet) {
            $this->searchResults = Product::with('barang')
                ->where('outlet_id', $this->selectedOutlet)
                ->whereHas('barang', function ($query) {
                    $query->where('nama', 'like', '%' . $this->searchQuery . '%');
                })
                ->where('stok', '>', 0)
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    // Dipanggil saat outlet dipilih
    public function updatedSelectedOutlet()
    {
        $this->cart = [];
        $this->searchQuery = '';
        $this->searchResults = [];
        $this->calculateGrandTotal();
    }

    public function addProductToCart($productId)
    {
        $product = Product::with('barang')->find($productId);
        if (!$product) return;

        // Cek jika produk sudah ada di keranjang
        if (isset($this->cart[$productId])) {
            // Cek stok sebelum menambah kuantitas
            if ($this->cart[$productId]['quantity'] < $product->stok) {
                $this->cart[$productId]['quantity']++;
            } else {
                $this->dispatch('toast', type: 'error', message: 'Stok tidak mencukupi!');
            }
        } else {
            $this->cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->barang->nama,
                'price' => $product->harga_jual,
                'quantity' => 1,
                'max_stok' => $product->stok
            ];
        }

        $this->searchQuery = '';
        $this->searchResults = [];
        $this->calculateGrandTotal();
    }
    
    public function updateCartQuantity($productId, $quantity)
    {
        if (isset($this->cart[$productId])) {
            $product = Product::find($productId);
            if ($quantity > 0 && $quantity <= $product->stok) {
                $this->cart[$productId]['quantity'] = $quantity;
            } else {
                $this->cart[$productId]['quantity'] = $product->stok;
                $this->dispatch('toast', type: 'error', message: 'Kuantitas melebihi stok!');
            }
        }
        $this->calculateGrandTotal();
    }
    
    public function removeCartItem($productId)
    {
        unset($this->cart[$productId]);
        $this->calculateGrandTotal();
    }

    public function calculateGrandTotal()
    {
        $this->grandTotal = 0;
        foreach ($this->cart as $item) {
            $this->grandTotal += $item['price'] * $item['quantity'];
        }
    }

    public function saveSale()
    {
        $this->validate([
            'selectedOutlet' => 'required',
            'customer_name' => 'required|string|max:100',
            'cart' => 'required|array|min:1'
        ]);

        DB::transaction(function () {
            // 1. Buat record Penjualan (Sale)
            $sale = Sale::create([
                'outlet_id' => $this->selectedOutlet,
                'customer_name' => $this->customer_name,
                'sale_date' => now(),
                'total' => $this->grandTotal,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->cart as $item) {
                // 2. Buat record untuk setiap item penjualan
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'harga_satuan' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);

                // 3. Kurangi stok produk
                $product = Product::find($item['product_id']);
                $product->decrement('stok', $item['quantity']);

                // 4. Buat catatan mutasi stok
                StockMutation::create([
                    'product_id' => $item['product_id'],
                    'outlet_id' => $this->selectedOutlet,
                    'quantity' => $item['quantity'],
                    'type' => 'out',
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                ]);
            }
        });

        $this->dispatch('toast', type: 'success', message: 'Transaksi berhasil disimpan!');
        
        // Reset form
        $this->reset(['cart', 'customer_name', 'grandTotal', 'searchQuery', 'searchResults']);
        $this->customer_name = 'Customer';
    }

    public function render()
    {
        return view('livewire.penjualan.pos-form');
    }
}