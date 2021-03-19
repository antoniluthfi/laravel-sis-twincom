@php
date_default_timezone_set('Asia/Jakarta');
$now = date("d m Y");   

$total = 0;
for ($i = 0; $i < count($data); $i++) {
    $total += intval($data[$i]->nominal);
}

$dari = date_create($dari);
$dari = date_format($dari, "d-M-Y");

$sampai = date_create($sampai);
$sampai = date_format($sampai, "d-M-Y");

if($sampai == $dari) {
    $sampai = '';
} else {
    $sampai = ' - ' . $sampai;
}

$pemasukan_tunai = 0;
$pemasukan_non_tunai = 0;
$pengeluaran_tunai = 0;
$pengeluaran_non_tunai = 0;
for ($i = 0; $i < count($data); $i++) { 
    if($data[$i]->transaksi->jenis_transaksi === 1) {
        if($data[$i]->kas === 0) {
            $pemasukan_tunai += intval($data[$i]->nominal);
        } else {
            $pemasukan_non_tunai += intval($data[$i]->nominal);
        }
    } else {
        if($data[$i]->kas === 0) {
            $pengeluaran_tunai += intval($data[$i]->nominal);
        } else {
            $pengeluaran_non_tunai += intval($data[$i]->nominal);
        }
    }
    
    $total = ($pemasukan_tunai + $pemasukan_non_tunai) - ($pengeluaran_tunai + $pengeluaran_non_tunai);
}

@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Laporan Arus Kas</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://tsc-api.twincom.co.id/public/css/app.css">
    </head>

    <body>
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <div class="container">
                <div class="row">
                    <div class="float-left" style="width: 10%;">
                        <img src="https://drive.google.com/thumbnail?id=12ubasd0uZrQ3LFlQ3Hw1mG4Q8ORLZ3Ao" width="80" height="80" alt="" class="mr-2">
                    </div>
                    <div class="float-right" style="width: 90%;">        
                        <h1 class="display-4 mt-0 mb-0 p-0">TWINCOM SERVICE CENTER {{ strtoupper($data[0]->cabang) }}</h1>
                        <p class="lead mt-0 mb-0 p-0">Banjarbaru : Jl. Panglima Batur Timur RT. 02 RW. 01 Ruko No. 6, Telp. 085245114690, 08115138800, 05116749897</p>
                        <p class="lead mt-0 mb-0 p-0">Landasan Ulin : Kp. Baru RT. 3 RW. 02 Jl. Seroja No. 11 Landasan Ulin Banjarbaru, Telp. 082255558174, 087815836366, 08115166995</p>
                        <p class="lead mt-0 mb-0 p-0">Banjarmasin : Jl. Adyaksa No. 4 (Deretan UNISKA) Kayutangi Banjarmasin, Telp. 082255558175, 08781664873, 085100159003</p>
                    </div>
                </div>
            </div>            
        </nav>  
        
        <h1 class="display-5 ml-1 mt-4 mb-2 p-0">LAPORAN ARUS KAS DAN TRANSAKSI LAIN-LAIN</h1>
        <div class="container mb-4">
            <div class="row">
                <div class="float-left" style="width: 30%;">  
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Tanggal</p>
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Pemasukan Tunai</p>
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Pemasukan Non-Tunai</p>
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Pengeluaran Tunai</p>
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Pengeluaran Non-Tunai</p>
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Total Keseluruhan</p>
                </div>
                <div class="float-right" style="width: 69%;">
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">: {{ $dari . $sampai }}</p>
                    <p class="lead-2 text-primary ml-1 mt-0 mb-0 p-0">: Rp. {{ number_format($pemasukan_tunai) }}</p>
                    <p class="lead-2 text-primary ml-1 mt-0 mb-0 p-0">: Rp. {{ number_format($pemasukan_non_tunai) }}</p>
                    <p class="lead-2 text-danger ml-1 mt-0 mb-0 p-0">: Rp. {{ number_format($pengeluaran_tunai) }}</p>
                    <p class="lead-2 text-danger ml-1 mt-0 mb-0 p-0">: Rp. {{ number_format($pengeluaran_non_tunai) }}</p>
                    <p class="lead-2 text-success ml-1 mt-0 mb-0 p-0">: Rp. {{ number_format($total) }}</p>
                </div>
            </div>
        </div>
        
        @for ($i = 0; $i < count($dataCount); $i++)
            @php
                if($dataCount[$i]->cabang === 'Banjarbaru') {
                    $sandi_transaksi = 'ST.BJB.' . $dataCount[$i]->id_sandi . ' - ' . $dataCount[$i]->sandi_transaksi;
                } elseif($dataCount[$i]->cabang === 'Landasan Ulin') {
                    $sandi_transaksi = 'ST.LNU.' . $dataCount[$i]->id_sandi . ' - ' . $dataCount[$i]->sandi_transaksi;
                } elseif ($dataCount[$i]->cabang === 'Banjarmasin') {
                    $sandi_transaksi = 'ST.BJM.' . $dataCount[$i]->id_sandi . ' - ' . $dataCount[$i]->sandi_transaksi;
                }

                if($dataCount[$i]->jenis_transaksi === 0) {
                    $jenis = 'Keluar';
                } else {
                    $jenis = 'Masuk';
                }
            @endphp

            <table class="table table-bordered">
                <thead>
                    <tr class="table-active">
                        <th scope="col" style="width: 40px;">#</th>
                        <th scope="col" class="text-left" style="width: 300px;">{{ $sandi_transaksi }}</th>
                        <th scope="col">Tanggal</th> 
                        <th scope="col">Kas Tunai/Bank</th> 
                        <th scope="col" style="width: 80px;">{{ $jenis }}</th> 
                    </tr>            
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total = 0;
                    @endphp
                    @for ($j = 0; $j < count($data); $j++) { 
                        @if ($data[$j]->id_sandi === $dataCount[$i]->id_sandi)
                            @php
                                $tanggal = date_format($data[$i]->created_at, "d M Y");

                                if($dataCount[$i]->no_service == 0) {
                                    $no_service = '';
                                } else {
                                    if($dataCount[$i]->cabang === 'Banjarbaru') {
                                        $no_service = ' - S.BJB.' . $dataCount[$i]->no_service; 
                                    } elseif($dataCount[$i]->cabang === 'Landasan Ulin') {
                                        $no_service = ' - S.LNU.' . $dataCount[$i]->no_service; 
                                    } elseif($dataCount[$i]->cabang === 'Banjarmasin') {
                                        $no_service = ' - S.BJM.' . $dataCount[$i]->no_service; 
                                    } else {
                                        $no_service = '';
                                    }
                                }

                                if($data[$j]->kas == 1) {
                                    $kas = $data[$i]->norekening;
                                } elseif($data[$j]->kas == 0) {
                                    $kas = 'Tunai';
                                }

                                $total += intval($data[$j]->nominal);
                            @endphp
                            <tr>
                                <th scope="row" class="text-center"><p class="lead-2">{{ $no++ }}</p></th>
                                <td scope="row" class=""><p class="lead-2">{{ $dataCount[$i]->keterangan . $no_service }}</p></td>
                                <td scope="row" class="text-center"><p class="lead-2">{{ $tanggal }}</p></td>
                                <td scope="row" class="text-center"><p class="lead-2">{{ $kas }}</p></td>
                                <td scope="row" class="text-right"><p class="lead-2">{{ number_format($data[$j]->nominal) }}</p></td>
                            </tr>
                        @endif
                    @endfor

                    <tr class="">    
                        <th scope="row" colspan="4" class="text-center" style="vertical-align: middle;"><p class="lead-2">Total</p></th>
                        <th scope="row" class="text-right"><p class="lead-2">{{ number_format($total) }}</p></th>
                    </tr>                        
                </tbody>
            </table>            
        @endfor

        <div class="float-right w-40">
            <p class="lead-2 text-center">{{ ucwords($data[0]->cabang) . ', ' . $now }}</p>
            <p class="lead-2 mt-6 text-center">{{ ucwords($nama_admin) }}</p>    
        </div>
    </body>
</html>