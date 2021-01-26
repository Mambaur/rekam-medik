<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Berkas Pasien</h1>
  <a href="<?= base_url();?>berkas/baru" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Berkas Pasien Baru</a>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <?= $this->session->flashdata('message'); ?>
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Tanggal Masuk</th>
                <th>No Rak</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($pasien as $item){ ?>
            <tr>
                <td style="width: 8%"><?= $item['no_rm']; ?></td>
                <td><?= $item['nama_pasien']; ?></td>
                <td><?= $item['tanggal_masuk']; ?></td>
                <td><?= $item['no_rak']; ?></td>
                <td style="width: 17%">
                    <a href="<?= base_url('berkas/update?id='. $item['id_pasien']);?>" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Lihat detail</span>
                    </a>
                </td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </div>
    </div>
</div>