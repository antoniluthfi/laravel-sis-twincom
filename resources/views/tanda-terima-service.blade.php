@php
if($data->cabang === 'Banjarbaru') {
    $no_service = "S.BJB.$data->no_service_penerimaan";
} elseif ($data->cabang === 'Landasan Ulin') {
    $no_service = "S.LNU.$data->no_service_penerimaan";
} elseif ($data->cabang === 'Banjarmasin') {
    $no_service = "S.BJM.$data->no_service_penerimaan";
}

if($data->data_penting === '1') {
    $data_penting = 'Ada';
} else {
    $data_penting = 'Tidak Ada';
}

$tanggal = explode(' ', $data->created_at);
$tanggal = explode('-', $tanggal[0]);
$tanggal = $tanggal[2] . '/' . $tanggal[1] . '/' . $tanggal[0];

if(strpos($data->teknisi, ',')) {
    $teknisi = explode(",", $data->teknisi);
    $teknisi = $teknisi[0];
} else {
    $teknisi = $data->teknisi;
}

date_default_timezone_set('Asia/Jakarta');
$now = date("d-m-Y");

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Service</title>
    <link rel="stylesheet" href="https://tsc-api.twincom.co.id/public/css/app.css">
</head>
<body style="font-family: serif;">
    <div class="float-left" style="width: 10%;">
        <img src="https://drive.google.com/thumbnail?id=12ubasd0uZrQ3LFlQ3Hw1mG4Q8ORLZ3Ao" width="80" height="80" alt="" class="mr-2">
    </div>
    <div class="float-left ml-1" style="width: 62%;">        
        <h1 class="display-5 mt-0 mb-0 p-0" style="font-weight: bold; letter-spacing: 1.5px;">TWINCOM SERVICE CENTER {{ strtoupper($data->cabang) }}</h1>
        <h1 class="display-6 mt-0 mb-0 p-0" style="font-weight: bold; letter-spacing: 1.5px;">KOMPUTER - LAPTOP - PRINTER - REFILL TONER - CCTV</h1>

        <p class="lead mt-0 mb-0 p-0">Banjarbaru : Jl. Panglima Batur Timur RT. 02 RW. 01 Ruko No. 6, Telp. 085245114690, 08115138800, 05116749897</p>
        <p class="lead mt-0 mb-0 p-0">Landasan Ulin : Kp. Baru RT. 3 RW. 02 Jl. Seroja No. 11 Landasan Ulin Banjarbaru, Telp. 082255558174, 087815836366, 08115166995</p>
        <p class="lead mt-0 mb-0 p-0">Banjarmasin : Jl. Adyaksa No. 4 (Deretan UNISKA) Kayutangi Banjarmasin, Telp. 082255558175, 08781664873, 085100159003</p>
    </div>
    <div class="float-right border" style="width: 26%">
        <div class="float-left" style="width: 84%">
            <h1 class="display-6 ml-2 mt-1 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">TANDA TERIMA SERVICE</h1>

            <div class="float-left" style="width: 100%;">
                <p class="lead ml-2 mt-0 mb-0">www.twincom.co.id</p>
                <p class="lead ml-2 mt-0 mb-1">twincom_bjb@yahoo.com</p>
            </div>
        </div>
        <div class="float-right border" style="width: 15%;">
            <h1 class="display-6 text-center" style="font-weight: bold;">U</h1>
        </div>

        <div class="clearfix">
            <div class="float-left" style="width: 43%">
                <p class="lead ml-2 mt-1 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Nomor Service</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Kode Pelanggan</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Nama Pelanggan</p>
                <p class="lead ml-2 mt-0 mb-1" style="font-weight: bold; letter-spacing: 1.5px;">Telp/Hp</p>
            </div>   
            
            <div class="float-right" style="width: 56%;">
                <p class="lead mt-1 mb-0">: {{ $no_service }}</p>
                <p class="lead mt-0 mb-0">: {{ $data->customer_id }}</p>
                <p class="lead mt-0 mb-0">: {{ $data->customer }}</p>
                <p class="lead mt-0 mb-1">: {{ $data->customer_nomorhp }}</p>
            </div>
        </div>
    </div>

    <div class="border mt-1" style="width: 100%; height: 173px;">
        <h1 class="display-6 text-center mt-1 mb-1" style="font-weight: bold; letter-spacing: 1.5px;">INFORMASI PENERIMAAN BARANG</h1>

        <div class="float-left" style="width: 15%;">
            <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Tgl Penerimaan</p>

            @if ($data->jenis_penerimaan === 'Jasa Lain-lain')
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Jasa</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Kelengkapan</p> 
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Catatan</p>
            @endif

            @if ($data->jenis_penerimaan === 'Persiapan Barang Baru')
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">No Faktur Penjualan</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Nama Barang</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Barang</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Catatan</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Kelengkapan</p>   
            @endif

            @if ($data->jenis_penerimaan === 'Penerimaan Barang Service')
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Nama Barang</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Barang</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Problem / Request</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Catatan</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Data Penting</p>                
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Kondisi</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Serial Number</p>
                <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Kelengkapan</p>   
            @endif

            <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Permintaan</p>
            <p class="lead ml-2 mt-0 mb-0" style="font-weight: bold; letter-spacing: 1.5px;">Estimasi Penyelesaian</p>
        </div>

        <div class="float-right" style="width: 85%;">
            <p class="lead ml-2 mt-0 mb-0">: {{ $tanggal }}</p>

            @if ($data->jenis_penerimaan === 'Jasa Lain-lain')
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->barang_jasa }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->kelengkapan }}</p>     
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->keterangan == null ? '-' : $data->keterangan }}</p>
            @endif

            @if ($data->jenis_penerimaan === 'Persiapan Barang Baru')
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->no_faktur }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->merek . ' '. $data->tipe }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->barang_jasa }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->keterangan }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->kelengkapan }}</p>          
            @endif

            @if ($data->jenis_penerimaan === 'Penerimaan Barang Service')
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->merek . ' '. $data->tipe }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->barang_jasa }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ ucwords($data->problem) }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->keterangan }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data_penting }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->kondisi }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->sn }}</p>
                <p class="lead ml-2 mt-0 mb-0">: {{ $data->kelengkapan }}</p>
            @endif

            <p class="lead ml-2 mt-0 mb-0">: {{ $data->permintaan }}</p>
            <p class="lead ml-2 mt-0 mb-0">: {{ $data->estimasi }}</p>
        </div>
    </div>

    <div class="border mt-1" style="width: 100%;">
        <ul class="mt-1 mb-1">
            <li><p class="lead mt-0 mb-0">Barang service yang tidak diambil dalam 3 (tiga) bulan setelah tanggal terima service, resiko kehilangan & kerusakan bukan tanggungjawab twincom</p></li>
            <li><p class="lead mt-0 mb-0">Kami akan berusaha menyelamatkan data namun tidak bertanggungjawab atas resiko kehilangan data</p></li> 
            <li><p class="lead mt-0 mb-0">Twincom tidak bertanggungjawab atas kerusakan selain yang tercantum pada tanda terima service</p></li>   
            <li><p class="lead mt-0 mb-0">Customer wajib mendapatkan :</p></li> 
            <ul type="square">
                <li><p class="lead mt-0 mb-0">Estimasi biaya dan waktu perbaikan</p></li>
                <li><p class="lead mt-0 mb-0">Konfirmasi biaya dari teknisi kami dan persetujuan oleh pelanggan</p></li>
                <li><p class="lead mt-0 mb-0">Garansi Perbaikan</p></li>
            </ul>   
        </ul>
    </div>

    <div class="border mt-1" style="width: 100%;">
        <div class="float-left mb-0 pb-1" style="width: 59%;">
            <p class="lead ml-2 mt-6 mb-0">Bila Anda Kecewa : 081347992722 / 08125042742</p>
            {{-- <p class="lead ml-2 mt-0 mb-2">Pengguna Sistem : </p> --}}
        </div>

        <div class="float-right mt-0" style="width: 40%;">
            <p class="lead text-center mt-2 mb-0">{{ ucwords($data->cabang) . ', ' . $now }}</p>
            
            <div class="float-left" style="width: 32%">
                <p class="lead text-center mt-0 mb-5">Diserahkan</p>
                <p class="lead text-center mt-0 mb-1">{{ ucwords($data->customer) }}</p>
            </div>
            
            <div class="float-left" style="width: 32%">
                <p class="lead text-center mt-0 mb-5">Diterima</p>
                <p class="lead text-center mt-0 mb-1">{{ ucwords($data->admin) }}</p>
            </div>

            <div class="float-left" style="width: 32%">
                <p class="lead text-center mt-0 mb-5">Teknisi PJ</p>
                <p class="lead text-center mt-0 mb-1">{{ $data->teknisi }}</p>
            </div>
        </div>
    </div>
</body>
</html>