
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
  <h1 class="h3 mb-0 text-gray-800">Detail berkas pasien</h1>
</div>

<form action="<?= base_url('berkas/updatepasien?id='.$pasien['id_pasien']);?>" method="post" class="user">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4 w-50 mx-auto">
        <div class="card-body">
            <!-- Nested Row within Card Body -->
            <div class="p-5">
                <div class="row d-flex justify-content-between mx-1">
                    <div class="form-group">
                        Nomor RM
                        <input type="text" name="no_rm" value="<?= $pasien['no_rm']; ?>" class="form-control form-control-user" placeholder="Nomor rekam medik...">
                    </div>
                    <div class="form-group">
                        NIK Pasien
                        <input type="text" name="nik" value="<?= $pasien['nik']; ?>" class="form-control form-control-user" placeholder="NIK pasien...">
                    </div>
                </div>
                <div class="form-group">
                    Nama Pasien
                    <input type="text" name="nama_pasien" value="<?= $pasien['nama_pasien']; ?>" class="form-control form-control-user" placeholder="Nama pasien...">
                </div>

                <div class="form-group">
                    Alamat Pasien
                    <input type="text" name="alamat" class="form-control form-control-user" placeholder="Alamat..." value="<?= $pasien['alamat']; ?>">
                </div>
                <div class="my-1 ml-1">Jenis Kelamin</div>
                <div class="btn-group ml-1 mb-1" data-toggle="buttons">
                    <?php 
                        if ($pasien['jeniskelamin'] == 'Perempuan') {
                            echo '
                            <label class="btn btn-secondary active">
                                <input type="radio" name="jk" value="Laki-laki" autocomplete="off"> Laki-laki
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="jk" value="Perempuan" autocomplete="off" checked> Perempuan
                            </label>
                            ';
                        }else{
                            echo '
                            <label class="btn btn-secondary active">
                                <input type="radio" name="jk" value="Laki-laki" autocomplete="off" checked> Laki-laki
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="jk" value="Perempuan" autocomplete="off"> Perempuan
                            </label>
                            ';
                        }
                    ?>
                </div>
                <div class="form-group">
                Nomor Rak Berkas
                    <input type="text" name="no_rak" class="form-control form-control-user" placeholder="Nomor Rak..." value="<?= $pasien['no_rak']; ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-1 mb-5">
        <a href="<?= base_url();?>berkas/" class="btn btn-secondary btn-icon-split mr-1">
            <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
        <button type="submit" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
            <span class="text">Perbarui Data Pasien</span>
        </button>
    </div>
</form>