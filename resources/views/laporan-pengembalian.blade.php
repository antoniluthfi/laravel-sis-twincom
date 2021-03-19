@php
date_default_timezone_set('Asia/Jakarta');
$now = date("d m Y");    

$total = 0;
for ($i = 0; $i < count($data); $i++) {
    $total += intval($data[$i]->nominal);
}

$dari = explode('-', $dari);
$dari = $dari[2] . '-' . $dari[1] . '-' . $dari[0];

if($sampai === 'x') {
    $sampai = '';
} else {
    $sampai = explode('-', $sampai);
    $sampai = ' - ' . $sampai[2] . '-' . $sampai[1] . '-' . $sampai[0];
}

@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Laporan Pengembalian Dan Pembayaran Service</title>
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
        
        <h1 class="display-5 ml-1 mt-4 mb-2 p-0">LAPORAN PEMBAYARAN DAN PENGEMBALIAN SERVICE</h1>
        <div class="container mb-4">
            <div class="row">
                <div class="float-left" style="width: 30%;">  
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Tanggal</p>
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">Total Biaya Service</p>
                </div>
                <div class="float-right" style="width: 69%;">
                    <p class="lead-2 ml-1 mt-0 mb-0 p-0">: {{ $dari . $sampai }}</p>
                    <p class="lead-2 text-success ml-1 mt-0 mb-0 p-0">: Rp. {{ number_format($total) }}</p>
                </div>
            </div>
        </div>            

        <table class="table table-bordered">
            <thead>
                <tr class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">No Nota</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Barang/Jasa</th>
                    <th scope="col">Solusi</th>
                    <th scope="col">Tgl Terima</th>
                    <th scope="col">Tgl Selesai</th>
                    <th scope="col">Tgl Kembali</th>
                    <th scope="col">Teknisi</th>
                    <th scope="col">Diserahkan</th>
                    <th scope="col">Nominal</th>
                    <th scope="col">Status Kembali</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($data); $i++)
                    @php
                        if($data[$i]['cabang'] === 'Banjarbaru') {
                            $no_service = "S.BJB." . $data[$i]->no_service;
                        } elseif($data[$i]['cabang'] === 'Landasan Ulin') {
                            $no_service = "S.LNU." . $data[$i]->no_service;
                        } elseif($data[$i]['cabang'] === 'Banjarmasin') {
                            $no_service = "S.BJM." . $data[$i]->no_service;
                        }

                        if($data[$i]->pengerjaan->status_pengerjaan === 3) {
                            $status = 'Selesai';
                        } elseif($data[$i]->pengerjaan->status_pengerjaan === 2) {
                            $status = 'Sedang Dikerjakan';
                        } elseif($data[$i]->pengerjaan->status_pengerjaan === 1) {
                            $status = 'Cancel';
                        } elseif($data[$i]->pengerjaan->status_pengerjaan === 0) {
                            $status = 'Belum Dikerjakan';
                        }          
                    @endphp
                    <tr class="' . $table_color . '">
                        <th scope="row"><p class="lead-2">{{ $i + 1 }}</p></th>
                        <td><p class="lead-2">{{ $no_service }}</p></td>
                        <td><p class="lead-2">{{ ucwords($data[$i]->penerimaan->customer->nama) . ' - ' . $data[$i]->penerimaan->customer->nomorhp }}</p></td>
                        <td><p class="lead-2">{{ $data[$i]->penerimaan->bj->nama_bj . ' ' . $data[$i]->penerimaan->merek . ' ' . $data[$i]->penerimaan->tipe }}</p></td>
                        <td><p class="lead-2">{{ $data[$i]->detailPengerjaan->pengerjaan }}</p></td>
                        <td><p class="lead-2">{{ $data[$i]->penerimaan->created_at }}</p></td>
                        <td><p class="lead-2">{{ $data[$i]->detailPengerjaan->waktu_selesai }}</p></td>
                        <td><p class="lead-2">{{ $data[$i]->created_at }}</p></td>
                        <td><p class="lead-2">{{ ucwords($data[$i]->pj->teknisi->name) }}</p></td>
                        <td><p class="lead-2">{{ ucwords($nama_admin) }}</p></td>
                        <td><p class="lead-2">{{ number_format($data[$i]->nominal) }}</p></td>
                        <td><p class="lead-2">{{ $status }}</p></td>
                    </tr> 
                @endfor
            </tbody>
        </table>

        <div class="float-right w-40">
            <p class="lead-2 text-center">{{ ucwords($data[0]->cabang) . ', ' . $now }}</p>
            <p class="lead-2 mt-6 text-center">{{ ucwords($nama_admin) }}</p>    
        </div>

    </body>
</html>';