
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mb-4">
  <h1 class="h3 mb-0 text-gray-800">Petugas Baru</h1>
</div>

<!-- Basic Card Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <!-- Nested Row within Card Body -->
        <form class="user">
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-5">
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                                Nama Petugas
                            </div>
                            <input type="text" name="nama-distributor" class="form-control form-control-user" placeholder="Nama Petugas...">
                        </div>
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                                Email
                            </div>
                            <input type="email" name="email" class="form-control form-control-user" placeholder="Email Petugas...">
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="py-5 pr-5">
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                               Password
                            </div>
                            <input type="password" name="notelp" class="form-control form-control-user" placeholder="Password...">
                        </div>
                        <div class="form-group">
                            <div class="ml-1 mb-1">
                                Konfirmasi Password
                            </div>  
                            <input type="password" name="notelp" class="form-control form-control-user" placeholder="Konfirmasi Password...">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="d-flex justify-content-center mt-1 mb-5">
    <a href="<?= base_url();?>berkas/petugas" class="btn btn-secondary btn-icon-split mr-1">
        <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
    </a>
    <a href="#" class="btn btn-success btn-icon-split">
        <span class="icon text-white-50">
        <i class="fas fa-check"></i>
        </span>
        <span class="text">Tambah Petugas</span>
    </a>
</div>