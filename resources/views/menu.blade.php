<!DOCTYPE html>
<html>
<head>
    <title>SanyCanteen</title>

    <style>
        body{
            font-family: Arial;
            background: #f4f6f9;
            padding: 40px;
        }

        h1{
            text-align: center;
        }

        .vendor-select{
            width: 300px;
            padding: 10px;
            margin: 20px auto;
            display: block;
        }

        .grid{
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 20px;
        }

        .card{
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card img{
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .card h3{
            margin: 10px 0;
        }

        .price{
            color: green;
            font-weight: bold;
        }

        button{
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover{
            background: #0056b3;
        }
    </style>
</head>

<body>

<div style="text-align:right;margin-bottom:20px;">
    <a href="/vendor" style="
    background:#28a745;
    color:white;
    padding:10px 15px;
    border-radius:5px;
    text-decoration:none;
    ">
    Login Vendor
    </a>
</div>

<h1>SanyCanteen</h1>

<select id="vendorSelect" class="vendor-select">
    <option value="">Semua Vendor</option>

    @foreach($vendors as $vendor)
        <option value="{{$vendor->idvendor}}">
            {{$vendor->nama_vendor}}
        </option>
    @endforeach
</select>

<div class="grid" id="menu-grid">

    @foreach($menus as $menu)
        <div class="card menu-card" data-vendor="{{$menu->idvendor}}">

            <img src="{{ asset('storage/menu/'.$menu->path_gambar) }}">

            <h3>{{$menu->nama_menu}}</h3>

            <p class="price">Rp {{$menu->harga}}</p>

            <form method="POST" action="/pesan">
@csrf

<input type="hidden" name="idmenu" value="{{$menu->idmenu}}">

<input type="number" name="jumlah" value="1" min="1">

<br><br>

<button type="submit">Pesan</button>

</form>

        </div>
    @endforeach

</div>

<script>
document.getElementById("vendorSelect").addEventListener("change", function(){

    let vendor = this.value
    let menus = document.querySelectorAll(".menu-card")

    menus.forEach(function(menu){

        if(vendor === "" || menu.dataset.vendor === vendor){
            menu.style.display = "block"
        } else {
            menu.style.display = "none"
        }

    })

})
</script>

</body>
</html>