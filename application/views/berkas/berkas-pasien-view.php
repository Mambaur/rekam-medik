<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Berkas Pasien</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
                <th>No Rak</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 8%">1</td>
                <td>System Architect</td>
                <td>Edinburgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td style="width: 17%">
                    <a href="<?= base_url();?>berkas/update" class="btn btn-secondary btn-icon-split">
                        <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                        </span>
                        <span class="text">Lihat detail</span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>
</div>