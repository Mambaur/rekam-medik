
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <a href="<?= base_url();?>berkas/baru" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Berkas Baru</a>
</div>

<!-- Content Row -->
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pasien</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($this->db->get('pasien')->result_array()); ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-calendar fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Distributor</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($this->db->get('distributor')->result_array()); ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Pengunjung hari ini</div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                <?php
                // echo date('d-m-Y');
                $temp = 0;
                $datapengunjung = $this->db->get('detail_pinjam')->result_array();
                if ($datapengunjung) {
                  foreach ($datapengunjung as $item) {
                    if ($item['keterangan'] != 'Pengembalian' && $item['tanggal'] == date('Y-m-d')) {
                      $temp = 1;
                      $pengunjung[] = $item['keterangan'];
                    }
                  }
                  if ($temp == 1) {
                    echo count($pengunjung);
                  }else{
                    echo 0;
                  }
                }else{
                  echo 0;
                }
                ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Jumlah Poli</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">
              <?php 
              $temp2 = 0;
              $datapoli = $this->db->get('poli')->result_array();
              if ($datapoli) {
                foreach ($datapoli as $item2) {
                  if ($item2['nama_poli'] != '-') {
                    $temp2 = 1;
                    $poli[] = $item2['nama_poli'];
                  }
                }
                if ($temp2 == 1) {
                  echo count($poli);
                }else{
                  echo 0;
                }
              }else{
                echo 0;
              }
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-comments fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="m-5 navbar-search">
  <div class="input-group">
      <input type="text" class="form-control bg-light border-1 small p-4" id="inputsearch" placeholder="Cari Pasien...">
      <div class="input-group-append">
      <button id="search" class="btn btn-primary px-4" type="button">
          <i class="fas fa-search fa-sm"></i>
      </button>
      </div>
  </div>
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
                <th>No RM</th>
                <th>Nama Pasien</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
                <th>No Rak</th>
                <th></th>
            </tr>
            </thead>
            <div>
              <tbody id="hasil">
              <?php
              $no = 1;
              foreach ($pasien as $item) { ?>
              <tr>
                  <td style="width: 8%"><?= $no++ ?></td>
                  <td><?= $item['no_rm'] ?></td>
                  <td><?= $item['nama_pasien'] ?></td>
                  <td><?= $item['status'] ?></td>
                  <td><?= $item['tanggal_masuk'] ?></td>
                  <td><?= $item['no_rak'] ?></td>
                  <td style="width: 27%" class="text-center">
                    <form 
                      action="
                      <?php
                        if ($item['status'] == '-') {
                          echo base_url('dashboard/peminjaman');
                        }else{
                          echo base_url('dashboard/pengembalian');
                        }
                      ?>"
                      method="post">

                      <input type="hidden" name="id_pasien" value="<?= $item['id_pasien']; ?>">
                      <input type="hidden" name="id_pinjam" value="<?= $item['id_peminjaman']; ?>">
                      <input type="hidden" name="id_distributor" value="<?= $item['distributor']; ?>">
                      <input type="hidden" name="poli" value="<?= $item['status'] ?>">
                      
                      
                      <?php 
                      if ($item['status'] == '-') {
                        echo '
                        <button type="submit" class="btn btn-success btn-icon-split">
                          <span class="icon text-white-50">
                          <i class="fas fa-check"></i>
                          </span>
                          <span class="text">Kirim</span>
                        </button>
                        ';
                      }else{
                        echo '
                        <button type="submit" class="btn btn-warning btn-icon-split">
                          <span class="icon text-white-50">
                          <i class="fas fa-arrow-left"></i>
                          </span>
                          <span class="text">Kembali</span>
                        </button>
                        ';
                      }
                      ?>
                      
                      <a href="<?= base_url('dashboard/hapus?id='.$item['id_peminjaman']);?>" class="btn btn-danger btn-icon-split">
                          <span class="icon text-white-50">
                          <i class="fas fa-trash"></i>
                          </span>
                          <span class="text">Hapus</span>
                      </a>
                    </form>
                  </td>
              </tr>
              <?php
              }
              ?>
              </tbody>
            </div>
        </table>
        </div>
    </div>
</div>

<script>
var keyword = document.getElementById('inputsearch');
var hasil = document.getElementById('hasil');
// var btnCari = document.getElementById('btn-cari');

keyword.addEventListener('keyup', function(){
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function(){
        if (ajax.readyState == 4 && ajax.status == 200) {
        hasil.innerHTML = ajax.responseText;
        }
    }

    ajax.open('GET', '<?php echo base_url("dashboard/search?keyword=");?>' + keyword.value,true);
    ajax.send();
});
</script>

