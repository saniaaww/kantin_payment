<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    // halaman scanner
    public function index()
    {
        return view('scan.index');
    }

    // ambil data pesanan dari QR
   public function getPesanan($id)
{
    // ambil pesanan
    $pesanan = Pesanan::where('idpesanan', $id)->first();

    // cek
    if(!$pesanan){

        return response()->json([
            'status' => 'error',
            'message' => 'Pesanan tidak ditemukan'
        ]);

    }

    // ambil detail menu
    $detail = DB::table('detail_pesanan')
                ->join(
                    'menu',
                    'detail_pesanan.idmenu',
                    '=',
                    'menu.idmenu'
                )
                ->where('detail_pesanan.idpesanan', $id)
                ->select(
                    'menu.nama_menu',
                    'detail_pesanan.jumlah'
                )
                ->get();

    // response
    return response()->json([

        'status' => 'success',

        'pesanan' => [
            'idpesanan' => $pesanan->idpesanan,
            'nama' => $pesanan->nama,
            'total' => $pesanan->total,
            'status_bayar' => $pesanan->status_bayar
        ],

        'menu' => $detail

    ]);
}
}