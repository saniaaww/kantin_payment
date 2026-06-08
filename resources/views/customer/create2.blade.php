<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<title>Tambah Customer 2</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<style>
body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#667eea,#764ba2);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.card{
    background:white;
    padding:30px;
    border-radius:20px;
    width:400px;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
}
h2{text-align:center;margin-bottom:20px;}
input, select{
    width:100%;
    padding:10px;
    margin-bottom:10px;
    border-radius:10px;
    border:1px solid #ddd;
}
button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:linear-gradient(45deg,#36d1dc,#5b86e5);
    color:white;
    font-weight:600;
    cursor:pointer;
    margin-bottom:5px;
}
.preview{text-align:center;}
.preview img{width:120px;border-radius:10px;}
.modal{
    display:none;
    position:fixed;
    width:100%;
    height:100%;
    top:0;
    left:0;
    background:rgba(0,0,0,0.5);
    justify-content:center;
    align-items:center;
}
.modal-content{
    background:white;
    padding:20px;
    border-radius:15px;
    text-align:center;
}
video{width:250px;border-radius:10px;}
</style>

</head>

<body>

<div class="card">

<h2>Tambah Customer</h2>

<form method="POST" action="/customer/store2">
@csrf

<input type="text" name="nama" placeholder="Nama">
<input type="text" name="alamat" placeholder="Alamat">

<select id="provinsi" name="provinsi">
<option>Pilih Provinsi</option>
</select>

<select id="kota" name="kota">
<option>Pilih Kota</option>
</select>

<select id="kecamatan" name="kecamatan">
<option>Pilih Kecamatan</option>
</select>

<select id="kelurahan" name="kelurahan">
<option>Pilih Kelurahan</option>
</select>

<input type="text" name="kodepos" id="kodepos" placeholder="Kode Pos" readonly>

<div class="preview">
<img id="preview">
</div>

<input type="hidden" name="foto" id="foto">

<button type="button" onclick="openModal()">📸 Ambil Foto</button>
<button type="submit">💾 Simpan Data</button>

</form>

</div>

<!-- MODAL -->
<div class="modal" id="modal">
<div class="modal-content">

<h3>Ambil Foto</h3>

<video id="video" autoplay></video>
<canvas id="canvas" style="display:none;"></canvas>

<br><br>

<button onclick="startCamera()">Nyalakan Kamera</button>
<button onclick="takePhoto()">Ambil Snapshot</button>
<button onclick="savePhoto()">Simpan Foto</button>

</div>
</div>

<script>

// =======================
// DATA KODE POS MANUAL
// =======================
const kodeposMap = {

    "Wonokromo": "60243",
    "Darmo": "60241",
    "Jagir": "60244",
    "Ngagel": "60246",

    "SUKOLILO": "60111",
    "KEPUTIH": "60111",
    "Gebang Putih": "60117",

    "Tegalsari": "60262",
    "Kedungdoro": "60261",

    "Gubeng": "60281",
    "Airlangga": "60286",

    "Rungkut Kidul": "60293",
    "Kalirungkut": "60293",

    "Gayungan": "60235",
    "Menanggal": "60234"

};

// =======================
// API WILAYAH
// =======================
const baseURL = "https://www.emsifa.com/api-wilayah-indonesia/api";

// PROVINSI
axios.get(baseURL + "/provinces.json")
.then(res=>{
    res.data.forEach(p=>{
        provinsi.innerHTML += `<option value="${p.id}">${p.name}</option>`;
    });
});

// PROVINSI → KOTA
provinsi.onchange = function(){

    kota.innerHTML = `<option>Pilih Kota</option>`;
    kecamatan.innerHTML = `<option>Pilih Kecamatan</option>`;
    kelurahan.innerHTML = `<option>Pilih Kelurahan</option>`;
    kodepos.value = "";

    axios.get(`${baseURL}/regencies/${this.value}.json`)
    .then(res=>{
        res.data.forEach(k=>{
            kota.innerHTML += `<option value="${k.id}">${k.name}</option>`;
        });
    });
};

// KOTA → KECAMATAN
kota.onchange = function(){

    kecamatan.innerHTML = `<option>Pilih Kecamatan</option>`;
    kelurahan.innerHTML = `<option>Pilih Kelurahan</option>`;
    kodepos.value = "";

    axios.get(`${baseURL}/districts/${this.value}.json`)
    .then(res=>{
        res.data.forEach(k=>{
            kecamatan.innerHTML += `<option value="${k.id}">${k.name}</option>`;
        });
    });
};

// KECAMATAN → KELURAHAN
kecamatan.onchange = function(){

    kelurahan.innerHTML = `<option>Pilih Kelurahan</option>`;
    kodepos.value = "";

    axios.get(`${baseURL}/villages/${this.value}.json`)
    .then(res=>{
        res.data.forEach(k=>{
            kelurahan.innerHTML += `<option value="${k.name}">${k.name}</option>`;
        });
    });
};

// KELURAHAN → KODEPOS (MANUAL)
kelurahan.onchange = function(){

    let nama = this.value;

    if(kodeposMap[nama]){
        kodepos.value = kodeposMap[nama];
    } else {
        kodepos.value = "Tidak tersedia";
    }

};

// =======================
// KAMERA
// =======================
function openModal(){
    modal.style.display = "flex";
}

function startCamera(){
    navigator.mediaDevices.getUserMedia({video:true})
    .then(stream=>{
        video.srcObject = stream;
    });
}

function takePhoto(){
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video,0,0);
}

function savePhoto(){
    let data = canvas.toDataURL("image/png");
    document.getElementById('foto').value = data;
    document.getElementById('preview').src = data;
    modal.style.display = "none";
}

</script>

</body>
</html>