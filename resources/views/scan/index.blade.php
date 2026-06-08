<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Scan QR Customer</title>

<script src="https://unpkg.com/html5-qrcode"></script>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    margin:0;
}

.card{
    width:420px;
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
    text-align:center;
}

h2{
    margin-bottom:20px;
}

#reader{
    width:100%;
}

.status{
    margin-top:15px;
    color:#666;
}

.result{
    margin-top:20px;
    background:#f5f5f5;
    padding:15px;
    border-radius:15px;
    text-align:left;
    display:none;
}

button{
    width:100%;
    margin-top:15px;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(45deg,#36d1dc,#5b86e5);
    color:white;
    font-weight:600;
    cursor:pointer;
}

</style>

</head>

<body>

<div class="card">

    <h2>📱 Scan QR Customer</h2>

    <!-- CAMERA -->
    <div id="reader"></div>

    <!-- STATUS -->
    <div class="status" id="status">
        Arahkan QR ke kamera
    </div>

    <!-- HASIL -->
    <div class="result" id="hasil"></div>

    <!-- BUTTON -->
    <button onclick="location.reload()">
        🔄 Scan Lagi
    </button>

</div>

<script>

// SAAT QR BERHASIL DIBACA
function onScanSuccess(decodedText){

    // 🔊 BEEP
    let audio = new Audio('/beep.mp3');
    audio.play();

    // STOP SCAN
    html5QrcodeScanner.clear();

    // STATUS
    document.getElementById('status').innerHTML =
        "QR berhasil dibaca";

    // FETCH DATA
    console.log(decodedText);

    fetch('/scan/' + decodedText)

    .then(response => response.json())

    .then(response => {

        if(response.status == 'success'){

            let p = response.pesanan;

            let html = `

                <h3>✅ Data Pesanan</h3>

                <p>
                    <b>ID Pesanan:</b>
                    ${p.idpesanan}
                </p>

                <p>
                    <b>Nama Customer:</b>
                    ${p.nama}
                </p>

                <p>
                    <b>Total:</b>
                    Rp ${p.total}
                </p>

                <p>
                    <b>Status:</b>
                    ${p.status_bayar == 1
                        ? 'LUNAS ✅'
                        : 'BELUM BAYAR ❌'}
                </p>

                <hr>

                <h3>🍔 Menu Pesanan</h3>
            `;

            response.menu.forEach(item => {

                html += `
                    <p>
                        • ${item.nama_menu}
                        (${item.jumlah}x)
                    </p>
                `;

            });

            // tampil hasil
            document.getElementById('hasil').innerHTML = html;

            document.getElementById('hasil').style.display = 'block';

        } else {

            document.getElementById('hasil').innerHTML =
                "Pesanan tidak ditemukan";

            document.getElementById('hasil').style.display = 'block';

        }

    });

}

// START SCANNER
let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    {
        fps:10,
        qrbox:250
    }
);

// JALANKAN
html5QrcodeScanner.render(onScanSuccess);

</script>

</body>
</html>