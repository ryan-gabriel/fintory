<?php

namespace App\Livewire;

use Livewire\Component;

class TerbilangInput extends Component
{
    public $jumlah = '';
    public $terbilang = 'Nol Rupiah';

    public function updatedJumlah()
    {
        // Remove all non-numeric characters
        $numeric = preg_replace('/[^0-9]/', '', $this->jumlah);

        // If empty, set to 0
        if (empty($numeric)) {
            $numeric = '0';
        }

        // Format as currency (Rupiah format)
        $this->jumlah = 'Rp ' . number_format((int) $numeric, 0, ',', '.');

        // Generate terbilang
        $this->terbilang = (int) $numeric === 0
            ? 'Nol Rupiah'
            : ucfirst(trim($this->terbilangIndo((int) $numeric))) . ' Rupiah';
    }

    public function terbilangIndo($number): string
    {
        $angka = [
            "",
            "satu",
            "dua",
            "tiga",
            "empat",
            "lima",
            "enam",
            "tujuh",
            "delapan",
            "sembilan",
            "sepuluh",
            "sebelas"
        ];

        if ($number < 12) {
            return " " . $angka[$number];
        } elseif ($number < 20) {
            return $this->terbilangIndo($number - 10) . " belas";
        } elseif ($number < 100) {
            return $this->terbilangIndo(intval($number / 10)) . " puluh" . $this->terbilangIndo($number % 10);
        } elseif ($number < 200) {
            return " seratus" . $this->terbilangIndo($number - 100);
        } elseif ($number < 1000) {
            return $this->terbilangIndo(intval($number / 100)) . " ratus" . $this->terbilangIndo($number % 100);
        } elseif ($number < 2000) {
            return " seribu" . $this->terbilangIndo($number - 1000);
        } elseif ($number < 1000000) {
            return $this->terbilangIndo(intval($number / 1000)) . " ribu" . $this->terbilangIndo($number % 1000);
        } elseif ($number < 1000000000) {
            return $this->terbilangIndo(intval($number / 1000000)) . " juta" . $this->terbilangIndo($number % 1000000);
        } elseif ($number < 1000000000000) {
            return $this->terbilangIndo(intval($number / 1000000000)) . " miliar" . $this->terbilangIndo($number % 1000000000);
        } elseif ($number < 1000000000000000) {
            return $this->terbilangIndo(intval($number / 1000000000000)) . " triliun" . $this->terbilangIndo($number % 1000000000000);
        } else {
            return "Angka terlalu besar";
        }
    }

    public function render()
    {
        return view('livewire.terbilang-input');
    }
}