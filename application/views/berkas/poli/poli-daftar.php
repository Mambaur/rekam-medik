
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Daftar Poli</h1>
  <a href="<?= base_url();?>berkas/polibaru" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Poli Baru</a>
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
                <th>Nama Poli</th>
                <th>Penanggung Jawab</th>
                <th>Nomor Telepon</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php 
            $no =1;
            foreach($poli as $item){
              if($item['nama_poli'] != '-') {
            ?>
            <tr>
                <td style="width: 8%"><?= $no++ ?></td>
                <td><?= $item['nama_poli'];?></td>
                <td><?= $item['penanggung_jawab'];?></td>
                <td><?= $item['telepon'];?></td>
                <td style="width: 15%">
                    <a href="<?= base_url('berkas/hapuspoli?id='. $item['id_poli']);?>" class="btn btn-danger btn-icon-split">
                        <span class="icon text-white-50">
                        <i class="fas fa-trash"></i>
                        </span>
                        <span class="text">Hapus</span>
                    </a>
                </td>
            </tr>
            <?php }} ?>
            </tbody>
        </table>
        </div>
    </div>
</div>