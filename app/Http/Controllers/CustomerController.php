<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
{
    $customer = Customer::all();

    return view('customer.index', compact('customer')); // WAJIB ADA INI
}

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $image = $request->photo;

        $image = str_replace('data:image/png;base64,', '', $image);
        $image = base64_decode($image);

        DB::table('customer')->insert([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'kodepos' => $request->kodepos,
            'foto_blob' => $image
        ]);

        return redirect('/customer');
    }

    public function create2()
{
    return view('customer.create2');
}

public function store2(Request $request)
{
  
    $request->validate([
        'nama' => 'required',
        'foto' => 'required'
    ]);

    $image = $request->foto;

    // bersihin base64
    $image = str_replace('data:image/png;base64,', '', $image);
    $image = str_replace(' ', '+', $image);

    // decode
    $image = base64_decode($image);

    // nama file
    $fileName = 'customer_' . time() . '.png';

    // simpan ke storage/app/public/customer
    \Storage::disk('public')->put('customer/' . $fileName, $image);

    // simpan ke database
    Customer::create([
        'nama' => $request->nama,
        'alamat' => $request->alamat,
        'provinsi' => $request->provinsi,
        'kota' => $request->kota,
        'kecamatan' => $request->kecamatan,
        'kodepos' => $request->kodepos,
        'foto' => 'storage/customer/' . $fileName
    ]);

    return redirect('/customer')->with('success', 'Data berhasil disimpan');
}
}