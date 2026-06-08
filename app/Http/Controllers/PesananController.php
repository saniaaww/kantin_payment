<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;

class PesananController extends Controller
{
    public function store(Request $request)
    {
        // ambil menu yang dipilih
        $menu = Menu::find($request->idmenu);

        // hitung total harga
        $total = $menu->harga * $request->jumlah;

        // buat nama guest otomatis
        $guest = 'Guest_' . rand(100000,999999);

        // simpan pesanan
        $pesanan = Pesanan::create([
            'nama' => $guest,
            'timestamp' => now(),
            'total' => $total,
            'metode_bayar' => null,
            'status_bayar' => 0,
            'snap_token' => null,
            'order_id_gateway' => null
        ]);

        // simpan detail pesanan
        DetailPesanan::create([
            'idmenu' => $menu->idmenu,
            'idpesanan' => $pesanan->idpesanan,
            'jumlah' => $request->jumlah,
            'harga' => $menu->harga,
            'subtotal' => $total
        ]);

        // redirect ke halaman pembayaran
        return redirect('/bayar/'.$pesanan->idpesanan);
    }
}