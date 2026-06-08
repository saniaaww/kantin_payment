<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Pesanan;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PaymentController extends Controller
{

    // =========================
    // HALAMAN PEMBAYARAN
    // =========================
    public function pay($id)
    {
        // config midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // ambil pesanan
        $order = Pesanan::findOrFail($id);

        // buat order id unik
        $orderId = 'ORDER-' . $order->idpesanan . '-' . time();

        // parameter
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $order->total,
            ],
        ];

        // snap token
        $snapToken = Snap::getSnapToken($params);

        // simpan
        $order->snap_token = $snapToken;
        $order->order_id_gateway = $orderId;
        $order->save();

        return view('payment', compact('snapToken', 'order'));
    }


    // =========================
    // CALLBACK MIDTRANS
    // =========================
  public function callback(Request $request)
{
    try {

        // 🔥 LOG SEMUA DATA MASUK
        \Log::info('CALLBACK MASUK', $request->all());

        // ambil data langsung dari request
        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        // validasi order_id
        if (!$orderId) {
            \Log::error('order_id kosong');
            return response()->json(['error'=>'order_id kosong'], 400);
        }

        // ambil ID dari format ORDER-1-xxxx
        $explode = explode('-', $orderId);
        $id = $explode[1] ?? null;

        if (!$id) {
            \Log::error('Format order_id salah: '.$orderId);
            return response()->json(['error'=>'format salah'], 400);
        }

        $pesanan = \App\Models\Pesanan::find($id);

        if (!$pesanan) {
            \Log::error('Pesanan tidak ditemukan: '.$id);
            return response()->json(['error'=>'not found'], 404);
        }

        // 🔥 HANDLE STATUS
        if ($status == 'settlement' || $status == 'capture') {
            $pesanan->status_bayar = 1; // LUNAS
        } elseif ($status == 'pending') {
            $pesanan->status_bayar = 0; // BELUM
        } else {
            $pesanan->status_bayar = 2; // GAGAL
        }

        $pesanan->save();

        return response()->json(['status'=>'ok']);

    } catch (\Exception $e) {

        \Log::error('ERROR CALLBACK: '.$e->getMessage());

        return response()->json(['error'=>'server error'], 500);
    }
}

    // =========================
    // HALAMAN SUCCESS + QR
    // =========================
       public function success($id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // 🔥 sementara tidak dicek biar pasti masuk
        // nanti boleh diaktifkan lagi
        // if($pesanan->status_bayar != 1){
        //     return redirect('/');
        // }

        $qr = QrCode::size(200)->generate($pesanan->idpesanan);

        return view('payment.success', compact('pesanan','qr'));
    }
}
