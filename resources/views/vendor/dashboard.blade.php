<!DOCTYPE html>
<html>
<head>

<title>Vendor Dashboard - SanyCanteen</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
padding:40px;
}

h1{
text-align:center;
margin-bottom:40px;
}

.grid{

display:grid;
grid-template-columns:repeat(2,1fr);
gap:25px;

}

.card{

background:white;
padding:30px;
border-radius:12px;
box-shadow:0 6px 15px rgba(0,0,0,0.1);
text-align:center;
transition:0.3s;

}

.card:hover{

transform:translateY(-5px);
box-shadow:0 10px 20px rgba(0,0,0,0.15);

}

.card h2{

margin-bottom:15px;

}

.card p{

color:#555;

}

.card a{

display:inline-block;
background:#007bff;
color:white;
padding:10px 18px;
border-radius:6px;
text-decoration:none;
margin-top:10px;

}

.card a:hover{

background:#0056b3;

}

.scan-btn{
background:#28a745 !important;
}

.scan-btn:hover{
background:#1f7e34 !important;
}

</style>

</head>

<body>

<h1>Dashboard Vendor</h1>

<div class="grid">

<!-- KELOLA MENU -->
<div class="card">

<h2>🍔 Kelola Menu</h2>

<p>Tambah atau ubah menu kantin</p>

<a href="/vendor/menu">Kelola Menu</a>

</div>

<!-- PESANAN -->
<div class="card">

<h2>💰 Pesanan Lunas</h2>

<p>Lihat pesanan yang sudah dibayar</p>

<a href="/vendor/pesanan">Lihat Pesanan</a>

</div>

<!-- SCAN QR -->
<div class="card">

<h2>📱 Scan QR Customer</h2>

<p>Scan QR pesanan customer</p>

<a href="/scan" class="scan-btn">
    Scan QR
</a>

</div>

<!-- CUSTOMER -->
<div class="card">

<h2>🏠 Halaman Customer</h2>

<p>Kembali ke halaman pemesanan</p>

<a href="/">Halaman Customer</a>

</div>

<div class="col-md-6 mb-4">

    <div class="card shadow border-0 h-100">

        <div class="card-body text-center p-5">

            <h2 class="mb-3">
                🔔 Antrian Realtime
            </h2>

            <p class="text-muted">
                Lihat dan panggil antrian customer
            </p>

            <a href="{{ route('vendor.antrian') }}"
               class="btn btn-warning btn-lg">

                Buka Antrian

            </a>

        </div>

    </div>

</div>
</div>

</body>
</html>