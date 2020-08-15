
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-center mt-5 mb-5">
  <h1 class="h3 mb-0 text-gray-800">Tambah Poli Baru</h1>
</div>

<form action="<?= base_url('berkas/politambah');?>" method="post" class="user">
    <!-- Basic Card Example -->
    <div class="card shadow mt-5 mb-4 w-50 mx-auto">
        <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <!-- Nested Row within Card Body -->
                <div class="p-3">
                    <div class="form-group">
                        <input type="text" name="nama_poli" class="form-control form-control-user" placeholder="Nama poli..." required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="telepon" class="form-control form-control-user" placeholder="Nomor telepon atau id telegram..." required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="penanggung_jawab" class="form-control form-control-user" placeholder="Penanggung Jawab..." required>
                    </div>
                </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-1 mb-5">
        <a href="<?= base_url();?>berkas/poli" class="btn btn-secondary btn-icon-split mr-2">
            <span class="icon text-white-50">
            <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
        <button type="submit" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
            <i class="fas fa-check"></i>
            </span>
            <span class="text">Tambah Poli</span>
        </button>
    </div>
</form>