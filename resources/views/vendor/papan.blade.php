<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Papan Antrian
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{

            margin:0;
            padding:0;

            background:
                linear-gradient(
                    135deg,
                    #0f172a,
                    #1e293b
                );

            height:100vh;

            overflow:hidden;

            font-family:Arial, Helvetica, sans-serif;

        }

        .wrapper{

            height:100vh;

            display:flex;

            justify-content:center;

            align-items:center;

        }

        .antrian-box{

            width:850px;

            border-radius:30px;

            background:white;

            padding:50px;

            box-shadow:
                0 0 40px rgba(0,0,0,0.4);

            text-align:center;

        }

        .judul{

            font-size:45px;

            font-weight:bold;

            margin-bottom:40px;

            color:#0f172a;

        }

        .nomor{

            font-size:170px;

            font-weight:bold;

            color:#2563eb;

            line-height:1;

        }

        .nama{

            margin-top:20px;

            font-size:45px;

            font-weight:bold;

            color:#111827;

        }

        .status{

            margin-top:30px;

        }

        .status span{

            font-size:28px;

            padding:15px 30px;

            border-radius:15px;

        }

    </style>

</head>

<body>

<div class="wrapper">

    <div class="antrian-box">

        <div class="judul">

            🔔 PAPAN ANTRIAN

        </div>

        <div class="text-secondary mb-3"
             style="font-size:30px;">

            NOMOR ANTRIAN

        </div>

        <div id="nomor"
             class="nomor">

            -

        </div>

        <div id="nama"
             class="nama">

            Menunggu Antrian...

        </div>

        <div id="status"
             class="status">

            <span class="badge bg-warning text-dark">

                Belum Ada Panggilan

            </span>

        </div>

    </div>

</div>

<script>

let lastId = 0;

// ==========================
// AKTIFKAN SUARA BROWSER
// ==========================

window.speechSynthesis.getVoices();

// ==========================
// CONNECT SSE
// ==========================

const eventSource =
    new EventSource(
        "/stream-antrian"
    );

// ==========================
// LISTEN EVENT
// ==========================

eventSource.onmessage = function(event){

    // kalau kosong
    if(!event.data) return;

    let data = JSON.parse(event.data);

    // kalau null
    if(!data) return;

    // supaya tidak bunyi terus
    if(data.idpesanan != lastId){

        lastId = data.idpesanan;

        // nomor
        document.getElementById(
            'nomor'
        ).innerHTML =
            'A-' + data.idpesanan;

        // nama
        document.getElementById(
            'nama'
        ).innerHTML =
            data.nama;

        // status
        document.getElementById(
            'status'
        ).innerHTML =

            `
            <span class="badge bg-success">

                Sedang Dipanggil

            </span>
            `;

        // bunyi
        bunyiPanggilan(data);

    }

};

// ==========================
// FUNCTION SUARA
// ==========================

function bunyiPanggilan(data){

    // stop suara sebelumnya
    window.speechSynthesis.cancel();

    let text =

        "Ting tong. " +

        "Nomor antrian A " +

        data.idpesanan +

        ". Atas nama " +

        data.nama +

        ". Silahkan menuju kasir.";

    let speech =
        new SpeechSynthesisUtterance(text);

    speech.lang = 'id-ID';

    speech.volume = 1;

    speech.rate = 0.9;

    speech.pitch = 1;

    window.speechSynthesis.speak(speech);

}

</script>

</body>
</html>