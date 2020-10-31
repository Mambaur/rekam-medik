
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Laporan Kunjungan</h1>
  <button onclick="printDiv('printableArea')" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-print fa-sm text-white-50"></i> Cetak Laporan</button>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body" id="printableArea">
        <div class="d-flex justify-content-center m-5">
            <h1 class="h3 mb-0 text-gray-800"><strong>BUKU EKSPEDISI REKAM MEDIK</strong></h1>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th rowspan="2" style="width: 5%" class="text-center">No</th>
                <th rowspan="2" class="text-center">Nomor RM</th>
                <th rowspan="2" class="text-center">Nama Pasien</th>
                <th colspan="3" class="text-center">Peminjaman</th>
                <th colspan="3" class="text-center">Pengembalian</th>
                <th rowspan="2" class="text-center">Keterangan</th>
            </tr>
            <tr>
                <th>Penanggung Jawab</th>
                <th>Bagian</th>
                <th>Tanggal</th>
                <th>Penanggung Jawab</th>
                <th>Bagian</th>
                <th>Tanggal</th>
            </tr>
            </thead>
            <tbody>
            <?php 
            // Menampilkan data dalam bentuk tabel
            $no = 1;
            foreach($laporan as $item){ ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $item['no_rm']; ?></td>
                <td><?= $item['nama_pasien']; ?></td>

                <?php 

                $poli = explode("Pengembalian dari ", $item['keterangan']);
                if ($item['tipe'] == 'Pengembalian') {
                    foreach ($poli as $i) {
                        $i = ' ' . $i;
                    }
                    echo '
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>'.$i.'</td>
                        <td>'.$i.'</td>
                        <td>'.$item['tanggal'].'</td>
                    ';
                }else{
                    echo '
                        <td>'.$item['penanggung_jawab'].'</td>
                        <td>'.$item['nama_poli'].'</td>
                        <td>'.$item['tanggal'].'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    ';
                }
                
                ?>
                <td><?php

                // Mendapatkan selisih keterlambatan
                date_default_timezone_set("Asia/Jakarta"); // set zona waktu indonesia

                if ($item['status'] == 'Terlambat') {
                    $awal  = new DateTime($item['waktu']); // Batas waktu pengembalian
                    $akhir = new DateTime(); // Waktu sekarang
                    $diff  = $awal->diff($akhir); // mendapatkan selisih

                    // Mengambil selisih tiap bulan, hari, dan jam
                    ($diff->m != 0) ? $month = $diff->m.' Bulan, ' : $month = ''; 
                    ($diff->d != 0) ? $day = $diff->d. ' Hari, ' : $day = '';
                    ($diff->h != 0) ? $hour = $diff->h. ' Jam' : $hour = '';

                    // Menampilkan keterangan dengan selisih waktu
                    echo $item['keterangan'] . '- Terlambat dikembalikan <br>'.$month.$day.$hour;
                }else{
                    // menampilkan keterangan saja
                    echo $item['keterangan']; 
                }
                ?>
                
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>