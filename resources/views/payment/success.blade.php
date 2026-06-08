<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Pembayaran Berhasil</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background: linear-gradient(135deg,#667eea,#38f9d7);
height:150vh;
display:flex;
align-items:center;
justify-content:center;
}

.container{
background:white;
padding:40px;
border-radius:20px;
width:400px;
text-align:center;
box-shadow:0 20px 40px rgba(0,0,0,0.2);
animation: fadeIn 0.6s ease;
}

@keyframes fadeIn{
from{opacity:0; transform:translateY(20px);}
to{opacity:1; transform:translateY(0);}
}

.icon{
font-size:60px;
margin-bottom:15px;
}

.title{
font-size:26px;
font-weight:600;
margin-bottom:10px;
color:#2ecc71;
}

.subtitle{
color:#777;
margin-bottom:25px;
}

.order-box{
background:#f7f7f7;
padding:20px;
border-radius:12px;
margin-bottom:20px;
}

.order-box p{
margin:5px 0;
font-size:14px;
}

.amount{
font-size:26px;
font-weight:700;
color:#27ae60;
}

.qr-box{
margin-top:20px;
}

.qr-box svg{
width:180px;
height:180px;
}

.success-text{
margin-top:10px;
font-size:13px;
color:#666;
}

.btn{
margin-top:25px;
display:inline-block;
padding:12px 25px;
border-radius:10px;
background:linear-gradient(45deg,#667eea,#764ba2);
color:white;
text-decoration:none;
font-weight:500;
transition:0.3s;
}

.btn:hover{
transform:scale(1.05);
box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

.footer{
margin-top:20px;
font-size:12px;
color:#aaa;
}

</style>

</head>

<body>

<div class="container">

<div class="icon">✅</div>

<div class="title">
Pembayaran Berhasil
</div>

<div class="subtitle">
Terima kasih, pesanan Anda sudah lunas
</div>

<div class="order-box">

<p><b>ID Pesanan</b></p>
<p>{{ $pesanan->idpesanan }}</p>

<br>

<p><b>Total Pembayaran</b></p>

<div class="amount">
Rp {{ number_format($pesanan->total,0,',','.') }}
</div>

</div>

<div class="qr-box">
    {!! $qr !!}
    <div class="success-text">
        Tunjukkan QR ini saat pengambilan pesanan
    </div>
</div>

<a href="/" class="btn">
Kembali ke Beranda
</a>

<div class="footer">
Powered by Midtrans
</div>

</div>

</body>
</html>