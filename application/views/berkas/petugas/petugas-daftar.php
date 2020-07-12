
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Daftar Petugas</h1>
  <a href="<?= base_url();?>berkas/petugasbaru" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Petugas Baru</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <?= $this->session->flashdata('message'); ?>
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>No</th>
                <th>Nama petugas</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $no = 1;
            foreach ($petugas as $item) { ?>
            <tr>
                <td style="width: 8%"><?= $no++ ?></td>
                <td><?= $item['nama_petugas']; ?></td>
                <td><?= $item['email']; ?></td>
                <td style="width: 15%">
                    <?php if($item['id_petugas'] == 1){ ?>
                        <a href="#" class="btn btn-secondary btn-icon-split">
                            <span class="icon text-white-50">
                            <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Hapus</span>
                        </a>
                    <?php }else { ?>
                        <a href="<?= base_url('berkas/hapuspetugas?id='.$item['id_petugas']);?>" class="btn btn-danger btn-icon-split">
                            <span class="icon text-white-50">
                            <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Hapus</span>
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
        </div>
    </div>
</div>