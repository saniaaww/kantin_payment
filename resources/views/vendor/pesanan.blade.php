<!DOCTYPE html>
<html>
<head>

<title>Pesanan Lunas</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
padding:40px;
}

h1{
text-align:center;
}

table{

width:80%;
margin:auto;
border-collapse:collapse;
background:white;

}

th,td{

padding:12px;
border:1px solid #ddd;
text-align:center;

}

th{

background:#007bff;
color:white;

}

</style>

</head>

<body>

<h1>Pesanan Lunas</h1>

<table>

<tr>

<th>ID Pesanan</th>
<th>Nama Customer</th>
<th>Total</th>

</tr>

@foreach($pesanan as $p)

<tr>

<td>{{$p->idpesanan}}</td>
<td>{{$p->nama}}</td>
<td>Rp {{$p->total}}</td>

</tr>

@endforeach

</table>

</body>
</html>
