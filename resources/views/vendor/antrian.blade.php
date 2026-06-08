<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Vendor Antrian
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

</head>

<body style="background:#f4f6f9;">

<div class="container py-4">

    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h1 class="fw-bold mb-0">

                🍽 Vendor Antrian

            </h1>

            <small class="text-muted">

                Sistem antrian realtime kantin

            </small>

        </div>

        <div>

            <a href="/vendor/papan"
               target="_blank"
               class="btn btn-dark rounded-3">

                <i class="fa-solid fa-tv"></i>

                Buka Papan

            </a>

        </div>

    </div>

    <!-- FILTER DATA -->

    @php

        $menunggu = $pesanan->where('status','menunggu');

        $dipanggil = $pesanan->where('status','dipanggil');

        $terlambat = $pesanan->where('status','terlambat');

        $selesai = $pesanan->where('status','selesai');

    @endphp

    <div class="row">

        <!-- MENUNGGU -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-warning rounded-top-4">

                    <h5 class="mb-0 fw-bold">

                        ⏳ Menunggu

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Total</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($menunggu as $item)

                            <tr>

                                <td>

                                    <span class="badge bg-dark p-2">

                                        A-{{ $item->idpesanan }}

                                    </span>

                                </td>

                                <td>

                                    {{ $item->nama }}

                                </td>

                                <td>

                                    Rp {{ number_format($item->total) }}

                                </td>

                                <td>

                                    <form action="/vendor/panggil/{{ $item->idpesanan }}"
                                          method="POST">

                                        @csrf

                                        <button class="btn btn-primary btn-sm rounded-3">

                                            <i class="fa-solid fa-volume-high"></i>

                                            Panggil

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center text-muted">

                                    Tidak ada antrian menunggu

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- DIPANGGIL -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-primary text-white rounded-top-4">

                    <h5 class="mb-0 fw-bold">

                        📢 Sedang Dipanggil

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Total</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($dipanggil as $item)

                            <tr>

                                <td>

                                    <span class="badge bg-primary p-2">

                                        A-{{ $item->idpesanan }}

                                    </span>

                                </td>

                                <td>

                                    {{ $item->nama }}

                                </td>

                                <td>

                                    Rp {{ number_format($item->total) }}

                                </td>

                                <td>

                                    <div class="d-flex gap-1">

                                        <form action="/vendor/selesai/{{ $item->idpesanan }}"
                                              method="POST">

                                            @csrf

                                            <button class="btn btn-success btn-sm rounded-3">

                                                Selesai

                                            </button>

                                        </form>

                                        <form action="/vendor/terlambat/{{ $item->idpesanan }}"
                                              method="POST">

                                            @csrf

                                            <button class="btn btn-danger btn-sm rounded-3">

                                                Terlambat

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center text-muted">

                                    Tidak ada antrian dipanggil

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- TERLAMBAT -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-danger text-white rounded-top-4">

                    <h5 class="mb-0 fw-bold">

                        🚫 Terlambat

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Total</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($terlambat as $item)

                            <tr>

                                <td>

                                    <span class="badge bg-danger p-2">

                                        A-{{ $item->idpesanan }}

                                    </span>

                                </td>

                                <td>

                                    {{ $item->nama }}

                                </td>

                                <td>

                                    Rp {{ number_format($item->total) }}

                                </td>

                                <td>

                                    <form action="/vendor/panggil/{{ $item->idpesanan }}"
                                          method="POST">

                                        @csrf

                                        <button class="btn btn-warning btn-sm rounded-3">

                                            <i class="fa-solid fa-rotate"></i>

                                            Panggil Lagi

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center text-muted">

                                    Tidak ada antrian terlambat

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- SELESAI -->

        <div class="col-lg-6 mb-4">

            <div class="card shadow border-0 rounded-4 h-100">

                <div class="card-header bg-success text-white rounded-top-4">

                    <h5 class="mb-0 fw-bold">

                        ✅ Selesai

                    </h5>

                </div>

                <div class="card-body">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Nama</th>
                                <th>Total</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($selesai as $item)

                            <tr>

                                <td>

                                    <span class="badge bg-success p-2">

                                        A-{{ $item->idpesanan }}

                                    </span>

                                </td>

                                <td>

                                    {{ $item->nama }}

                                </td>

                                <td>

                                    Rp {{ number_format($item->total) }}

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3"
                                    class="text-center text-muted">

                                    Belum ada antrian selesai

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>