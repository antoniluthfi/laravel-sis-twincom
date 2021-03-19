@php
if($data->admin->cab_penempatan === 'Banjarbaru') {
    $no_surat_jalan = 'SJ.BJB.' . $data->no_surat_jalan;
} elseif($data->admin->cab_penempatan === 'Landasan Ulin') {
    $no_surat_jalan = 'SJ.LNU.' . $data->no_surat_jalan;
} elseif($data->admin->cab_penempatan === 'Banjarmasin') {
    $no_surat_jalan = 'SJ.BJM.' . $data->no_surat_jalan;
}

date_default_timezone_set('Asia/Jakarta');
$now = date("d m Y");

@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="https://tsc-api.twincom.co.id/public/css/app.css">
    </head>
    <body>
        <div class="border" style="width: 100%;">
            <h1 class="display-4 text-center mt-0 mb-0 p-0" style="font-weight: bold;">SURAT JALAN</h1>
            <h1 class="display-4 text-center mt-0 mb-0 p-0" style="font-weight: bold;">TWINCOM SERVICE CENTER {{ strtoupper($data->admin->cab_penempatan) }}</h1>
            <p class="lead-2 text-center mt-0 mb-2 p-0">{{ $data->admin->cab_penempatan . ' : ' . $data->admin->cabang->alamat . ', ' . $data->admin->nomorhp }}</p>
        </div>

        <div class="border mt-1 mb-1" style="width: 100%;">
            <div class="float-left" style="width: 13%;">
                <p class="lead-nota ml-2 mt-1 mb-0">Nomor Surat Jalan</p>
                <p class="lead-nota ml-2 mt-0 mb-1">Dealer</p>
            </div>

            <div class="float-right" style="width: 87%;">
                <p class="lead-nota ml-2 mt-1 mb-0">: {{ $no_surat_jalan }}</p>
                <p class="lead-nota ml-2 mt-0 mb-1">: {{ $data->partner->nama }}</p>
            </div>                        
        </div>

        <table class="table table-bordered mt-0 mb-0">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Barang/Jasa</th>
                    <th scope="col">Kerusakan</th>
                    <th scope="col">Kelengkapan</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($data->list_pengiriman); $i++)
                    @php
                        if($data->list_pengiriman[$i]->penerimaan->cabang->nama_cabang === 'Banjarbaru') {
                            $no_service = 'S.BJB.' . $data->list_pengiriman[$i]->no_service;
                        } elseif($data->list_pengiriman[$i]->penerimaan->cabang->nama_cabang === 'Landasan Ulin') {
                            $no_service = 'S.LNU.' . $data->list_pengiriman[$i]->no_service;
                        } elseif($data->list_pengiriman[$i]->penerimaan->cabang->nama_cabang === 'Banjarmasin') {
                            $no_service = 'S.BJM.' . $data->list_pengiriman[$i]->no_service;
                        }
                    @endphp
                    <tr>
                        <th scope="row"><p class="lead-nota">1</p></th>
                        <td><p class="lead-nota">{{ $no_service . ' - ' . $data->list_pengiriman[$i]->penerimaan->merek . ' ' . $data->list_pengiriman[$i]->penerimaan->tipe }}</p></td>
                        <td><p class="lead-nota">{{ $data->list_pengiriman[$i]->penerimaan->sn }}</p></td>
                        <td><p class="lead-nota">{{ $data->list_pengiriman[$i]->penerimaan->bj->nama_bj }}</p></td>
                        <td><p class="lead-nota">{{ $data->list_pengiriman[$i]->kerusakan }}</p></td>
                        <td><p class="lead-nota">{{ $data->list_pengiriman[$i]->kelengkapan }}</p></td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <div class="border">
            <p class="lead-nota text-center mt-0 mb-0">{{ ucwords($data->admin->cab_penempatan) . ', ' . $now }}</p>
    
            <div class="float-left" style="width: 50%">
                <p class="lead-nota text-center mt-0 mb-5">Pengirim/Paraf</p>
                <p class="lead-nota text-center mt-0 mb-2">{{ ucwords($data->pengirim->name) }}</p>
            </div>

            <div class="float-left" style="width: 50%">
                <p class="lead-nota text-center mt-0 mb-5">Pengantar/Paraf</p>
                <p class="lead-nota text-center mt-0 mb-2">{{ ucwords($data->pengantar->name) }}</p>
            </div>
        </div>
    </body>
</html>
