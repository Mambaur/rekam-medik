
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
  <h1 class="h3 mb-0 text-gray-800">Petugas Baru</h1>
</div>

<form action="<?= base_url('berkas/petugastambah');?>" method="post" class="user">
    <!-- Basic Card Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                                Nama Petugas
                            </div>
                            <input type="text" name="nama_petugas" class="form-control form-control-user" placeholder="Nama Petugas..." required>
                        </div>
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                                Email
                            </div>
                            <input type="text" name="email" class="form-control form-control-user" placeholder="Email Petugas..." required>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="py-5 pr-5">
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                            Password
                            </div>
                            <input type="password" name="password" class="form-control form-control-user" placeholder="Password..." required>
                        </div>
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                                Konfirmasi Password
                            </div>  
                            <input type="password" name="konfirmasi_password" class="form-control form-control-user" placeholder="Konfirmasi Password..." required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-1 mb-5">
        <a href="<?= base_url();?>berkas/petugas" class="btn btn-secondary btn-icon-split mr-1">
            <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
        <button type="submit" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
            <span class="text">Tambah Petugas</span>
        </button>
    </div>
</form>