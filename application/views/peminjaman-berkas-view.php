
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mt-5 mb-5">
  <h1 class="h3 mb-0 text-gray-800">Pengiriman Berkas</h1>
</div>

<form action="<?= base_url('dashboard/peminjaman_aksi');?>" method="post">
    <input type="hidden" value="<?= $id_pinjam;?>" name="id_pinjam">
    <!-- Basic Card Example -->
    <div class="card shadow mt-5 mb-4 w-50 mx-auto">
        <div class="card-body">
            <!-- Nested Row within Card Body -->
                <div class="p-3">
                    <div class="form-group">
                        Pilih distributor
                        <select class="form-control" name="id_distributor">
                            <?php foreach($distributor as $index){ 
                            echo '<option value="'.$index['id_distributor'].'">'.$index['nama_distributor'].'</option>';
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                        Pilih poli
                        <select class="form-control" name="id_poli">
                            <?php foreach($poli as $item){ 
                                if ($item['id_poli'] != 1) {
                                    echo '<option value="'.$item['id_poli'].'">'.$item['nama_poli'].'</option>';
                                }
                            }?>
                        </select>
                    </div>
                    <div class="form-group">
                        Keterangan
                        <textarea class="form-control" name="keterangan" rows="3">Peminjaman Berkas</textarea>
                    </div>
                </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-1 mb-5">
        <button type="submit" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
            <span class="text">Kirim Berkas</span>
        </button>
    </div>
</form>