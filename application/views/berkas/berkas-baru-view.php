
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
  <h1 class="h3 mb-0 text-gray-800">Berkas Pasien Baru</h1>
</div>

<!-- Basic Card Example -->
<form action="<?= base_url('berkas/addberkas');?>" method="post" class="user">
    <div class="card shadow mb-4">
        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-5">
                            <div class="row d-flex justify-content-between mx-1">
                                <div class="form-group">
                                    <input type="text" name="norm" class="form-control form-control-user" placeholder="Nomor rekam medik..." required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nik" class="form-control form-control-user" placeholder="NIK pasien..." required>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nama_pasien" class="form-control form-control-user" placeholder="Nama pasien..." required>
                            </div>

                            <div class="form-group">
                                <input type="text" name="alamat" class="form-control form-control-user" placeholder="Alamat..." required>
                            </div>
                            <div class="my-1 ml-1">Jenis Kelamin</div>
                            <div class="btn-group ml-1" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="jk" value="Laki-laki" autocomplete="off" checked> Laki-laki
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="jk" value="Perempuan" autocomplete="off"> Perempuan
                                </label>
                            </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="py-5 pr-5">
                        <div class="form-group">
                            <input type="text" name="norak" class="form-control form-control-user" placeholder="Nomor Rak..." required>
                        </div>
                        <div class="row mx-1">
                            <div class="form-group mx-1 w-50">
                                Nama Distributor
                                <select class="form-control" name="id_distributor">
                                <?php foreach($distributor as $index){ 
                                echo '<option value="'.$index['id_distributor'].'">'.$index['nama_distributor'].'</option>';
                                }?>
                                </select>
                            </div>
                            <div class="form-group mx-1">
                                Nama Poli
                                <select class="form-control" name="id_poli">
                                <?php foreach($poli as $item){ 
                                    echo '<option value="'.$item['id_poli'].'">'.$item['nama_poli'].'</option>';
                                }?>
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control form-control-user" name="keterangan" id="keterangan" rows="3" required>Berkas pasien baru</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-1 mb-5">
        <button type="submit" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
            <span class="text">Tambah Pasien</span>
        </button>
    </div>
</form>