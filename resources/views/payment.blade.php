<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Pembayaran Pesanan</title>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="{{ config('midtrans.client_key') }}"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background: linear-gradient(135deg,#4facfe,#00f2fe);
height:100vh;
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
}

.title{
font-size:26px;
font-weight:600;
margin-bottom:10px;
}

.subtitle{
color:#777;
margin-bottom:25px;
}

.order-box{
background:#f7f7f7;
padding:20px;
border-radius:12px;
margin-bottom:25px;
}

.order-box p{
margin:5px 0;
}

.amount{
font-size:28px;
font-weight:700;
color:#2ecc71;
}

.pay-btn{
width:100%;
padding:15px;
border:none;
border-radius:12px;
background:linear-gradient(45deg,#667eea,#764ba2);
color:white;
font-size:18px;
font-weight:600;
cursor:pointer;
transition:0.3s;
}

.pay-btn:hover{
transform:scale(1.05);
box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

.icon{
font-size:50px;
margin-bottom:15px;
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

<div class="icon">💳</div>

<div class="title">
Pembayaran Pesanan
</div>

<div class="subtitle">
Silahkan selesaikan pembayaran
</div>

<div class="order-box">

<p><b>ID Pesanan</b></p>
<p>{{ $order->order_id_gateway }}</p>

<br>

<p><b>Total Pembayaran</b></p>

<div class="amount">
Rp {{ number_format($order->total,0,',','.') }}
</div>

</div>

<button id="pay-button" class="pay-btn">
Bayar Sekarang
</button>

<div class="footer">
Didukung oleh Midtrans
</div>

</div>

<script>

document.getElementById('pay-button').onclick = function(){

    snap.pay('{{ $snapToken }}', {

        onSuccess: function(result){

            alert("Pembayaran berhasil!");

            // 🔥 FIX KE QR PAGE
            window.location.href = "/payment/success/{{ $order->idpesanan }}";
        },

        onPending: function(result){
            alert("Menunggu pembayaran");
        },

        onError: function(result){
            alert("Pembayaran gagal");
        }

    });

};

</script>