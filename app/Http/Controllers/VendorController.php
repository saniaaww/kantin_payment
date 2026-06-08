<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Pesanan;
use App\Models\Vendor;

class VendorController extends Controller
{

    // =========================
    // DASHBOARD
    // =========================
    public function index()
    {

        return view('vendor.dashboard');

    }

    // =========================
    // HALAMAN MENU
    // =========================
    public function menu()
    {

        $vendors = Vendor::all();

        $menus = Menu::all();

        return view(
            'vendor.menu',
            compact(
                'vendors',
                'menus'
            )
        );

    }

    // =========================
    // SIMPAN MENU
    // =========================
    public function storeMenu(Request $request)
    {

        Menu::create([

            'nama_menu'   => $request->nama_menu,

            'harga'       => $request->harga,

            'idvendor'    => $request->idvendor,

            'path_gambar' => $request->path_gambar

        ]);

        return redirect('/vendor/menu');

    }

    // =========================
    // LIST PESANAN
    // =========================
    public function pesanan()
    {

        $pesanan = Pesanan::orderBy(
                            'idpesanan',
                            'desc'
                        )->get();

        return view(
            'vendor.pesanan',
            compact('pesanan')
        );

    }

    // =========================
    // HALAMAN ANTRIAN
    // =========================
    public function antrian()
    {

        $pesanan = Pesanan::where(
                            'status_bayar',
                            1
                        )
                        ->orderBy(
                            'idpesanan',
                            'asc'
                        )
                        ->get();

        return view(
            'vendor.antrian',
            compact('pesanan')
        );

    }

    // =========================
    // PANGGIL ANTRIAN
    // =========================
    public function panggil($id)
{
    $cek = Pesanan::where(
                    'status',
                    'dipanggil'
                )->first();

    // kalau masih ada
    if($cek){

        return back()->with(
            'error',
            'Masih ada antrian dipanggil'
        );

    }

    // ambil pesanan
    $pesanan = Pesanan::where(
                            'idpesanan',
                            $id
                        )->first();

    if($pesanan){

        $pesanan->status = 'dipanggil';

        $pesanan->save();

    }

    return back();

}

    // =========================
    // SELESAI
    // =========================
    public function selesai($id)
    {

        $pesanan = Pesanan::where(
                            'idpesanan',
                            $id
                        )->first();

        if($pesanan){

            $pesanan->status = 'selesai';

            $pesanan->save();

        }

        return redirect()->back();

    }

    // =========================
    // TERLAMBAT
    // =========================
    public function terlambat($id)
    {

        $pesanan = Pesanan::where(
                            'idpesanan',
                            $id
                        )->first();

        if($pesanan){

            $pesanan->status = 'terlambat';

            $pesanan->save();

        }

        return redirect()->back();

    }

    // =========================
    // PAPAN ANTRIAN
    // =========================
    public function papan()
    {

        return view('vendor.papan');

    }

    // =========================
    // DATA PAPAN
    // =========================
    public function dataPapan()
    {

        // sedang dipanggil
        $dipanggil = Pesanan::where(
                                'status',
                                'dipanggil'
                            )
                            ->orderBy(
                                'idpesanan',
                                'desc'
                            )
                            ->first();

        // antrian menunggu
        $menunggu = Pesanan::where(
                                'status',
                                'menunggu'
                            )
                            ->orderBy(
                                'idpesanan',
                                'asc'
                            )
                            ->get();

        // antrian terlambat
        $terlambat = Pesanan::where(
                                'status',
                                'terlambat'
                            )
                            ->orderBy(
                                'idpesanan',
                                'asc'
                            )
                            ->get();

        return response()->json([

            'dipanggil' => $dipanggil,

            'menunggu' => $menunggu,

            'terlambat' => $terlambat

        ]);

    }

    // =========================
    // SSE STREAM
    // =========================
    public function stream()
{
    return response()->stream(function () {

        while (true) {

            if(connection_aborted()){
                break;
            }

            $pesanan = Pesanan::where(
                            'status',
                            'dipanggil'
                        )
                        ->latest('idpesanan')
                        ->first();

            echo "data: " .
                json_encode($pesanan) .
                "\n\n";

            ob_flush();
            flush();

            usleep(300000);

        }

    }, 200, [

        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive',

    ]);
}

}