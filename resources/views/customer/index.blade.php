<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Data Customer</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    padding:30px;
}

.container{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

.title{
    font-size:26px;
    font-weight:600;
    margin-bottom:20px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    margin-bottom:20px;
}

.btn{
    padding:10px 15px;
    border:none;
    border-radius:10px;
    color:white;
    text-decoration:none;
    font-size:14px;
}

.btn-add{
    background:linear-gradient(45deg,#667eea,#764ba2);
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    text-align:left;
    vertical-align:middle;
}

th{
    background:#f7f7f7;
}

tr:nth-child(even){
    background:#fafafa;
}

img{
    width:70px;
    border-radius:10px;
    object-fit:cover;
}

.badge{
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
    background:#2ecc71;
    color:white;
}

.empty{
    text-align:center;
    padding:20px;
    color:#888;
}

.wilayah{
    font-size:13px;
    line-height:1.4;
}

</style>

</head>

<body>

<div class="container">

<div class="top-bar">
    <div class="title">Data Customer</div>

    <div>
        <a href="/customer/create" class="btn btn-add">+ Customer 1</a>
        <a href="/customer/create2" class="btn btn-add">+ Customer 2</a>
    </div>
</div>

<table>

<thead>
<tr>
    <th>No</th>
    <th>Foto</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>Wilayah</th>
    <th>Kode Pos</th>
</tr>
</thead>

<tbody>

@if(count($customer) > 0)

@foreach($customer as $i => $c)
<tr>

<td>{{ $i+1 }}</td>

<td>
    {{-- FOTO FILE (Customer 2) --}}
    @if(!empty($c->foto))
        <img src="{{ asset($c->foto) }}">
    
    {{-- FOTO BLOB (Customer 1) --}}
    @elseif(!empty($c->foto_blob))
        <img src="data:image/png;base64,{{ base64_encode($c->foto_blob) }}">
    @else
        -
    @endif
</td>

<td>{{ $c->nama }}</td>

<td>{{ $c->alamat }}</td>

<td class="wilayah">
    {{ $c->provinsi ?? '-' }}<br>
    {{ $c->kota ?? '-' }}<br>
    {{ $c->kecamatan ?? '-' }}<br>
    {{ $c->kelurahan ?? '-' }}
</td>

<td>
    <span class="badge">
        {{ $c->kodepos ?? '-' }}
    </span>
</td>

</tr>
@endforeach

@else

<tr>
<td colspan="6" class="empty">
Belum ada data customer 😢
</td>
</tr>

@endif

</tbody>

</table>

</div>

</body>
</html>