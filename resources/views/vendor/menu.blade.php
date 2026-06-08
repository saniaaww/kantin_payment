<!DOCTYPE html>
<html>
<head>

<title>Kelola Menu</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
padding:40px;
}

h1{
text-align:center;
}

.form-box{

background:white;
padding:20px;
border-radius:10px;
width:400px;
margin:auto;
box-shadow:0 4px 10px rgba(0,0,0,0.1);

}

input,select{

width:100%;
padding:10px;
margin-top:10px;

}

button{

margin-top:15px;
background:#28a745;
color:white;
border:none;
padding:10px;
width:100%;
border-radius:5px;
cursor:pointer;

}

button:hover{

background:#1e7e34;

}

.menu-list{

margin-top:40px;

}

.card{

background:white;
padding:15px;
border-radius:10px;
margin-bottom:15px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);

}

</style>

</head>

<body>

<h1>Kelola Menu Vendor</h1>

<div class="form-box">

<form method="POST" action="/vendor/menu/store">

@csrf

<select name="idvendor">

@foreach($vendors as $vendor)

<option value="{{$vendor->idvendor}}">
{{$vendor->nama_vendor}}
</option>

@endforeach

</select>

<input type="text" name="nama_menu" placeholder="Nama Menu">

<input type="number" name="harga" placeholder="Harga">

<input type="text" name="path_gambar" placeholder="gambar.jpg">

<button type="submit">Tambah Menu</button>

</form>

</div>

<div class="menu-list">

<h2>Daftar Menu</h2>

@foreach($menus as $menu)

<div class="card">

<b>{{$menu->nama_menu}}</b>

<br>

Harga: Rp {{$menu->harga}}

</div>

@endforeach

</div>

</body>
</html>