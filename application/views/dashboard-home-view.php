<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url();?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-cog"></i>
        </div>
        <div class="sidebar-brand-text mx-3">REKAM MEDIK</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?= base_url();?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Berkas</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url();?>berkas/baru">Berkas Pasien Baru</a>
            <a class="collapse-item" href="<?= base_url();?>berkas">Data Rekam Medik</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Poli</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url();?>berkas/poli">Daftar Poli</a>
            <a class="collapse-item" href="<?= base_url();?>berkas/polibaru">Tambah Poli</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Distributor</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url();?>berkas/distributor">Semua Distributor</a>
            <a class="collapse-item" href="<?= base_url();?>berkas/distributorbaru">Tambah Distributor</a>
          </div>
        </div>
      </li>
      
      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url();?>berkas/petugas">
          <i class="fas fa-fw fa-user"></i>
          <span>Petugas</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url();?>laporan">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Laporan</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link notifPushSidebar" href="<?= base_url();?>pesan">
          <i class="fas fa-comments"></i>
          <span>Pesan</span></a>
      </li>
      
      <!-- Nav Item - Logout -->
      <li class="nav-item">
        <a class="nav-link notifPushSidebar" href="<?= base_url();?>auth">
          <i class="fas fa-fw fa-sign-in-alt"></i>
          <span>Login</span></a>
      </li>


      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

  <!-- Topbar -->
  <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
      <i class="fa fa-bars"></i>
    </button>


    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

      <!-- Nav Item - Search Dropdown (Visible Only XS) -->
      <li class="nav-item dropdown no-arrow d-sm-none">
        <!-- Dropdown - Messages -->
        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
          <form class="form-inline mr-auto w-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      

      <!-- Nav Item - Messages -->
      <li class="nav-item dropdown no-arrow mx-1">
      </li>

      <!-- Nav Item - User Information -->
      <li class="nav-item dropdown no-arrow">
        
      </li>

    </ul>

  </nav>
  <!-- End of Topbar -->

  <!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  <a href="<?= base_url();?>berkas/baru" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Berkas Pasien Baru</a>
</div>

<!-- Content Row -->
<div class="row">

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Pasien hari ini</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($this->db->get_where('pasien', ['tanggal_masuk' => date('d-m-Y')])->result_array()); ?></div>
          </div>
          <div class="col-auto">
            <i class="fas fa-user fa-2x text-gray-300"></i>
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
            <i class="fas fa-user-nurse fa-2x text-gray-300"></i>
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
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah berkas yang dipinjam</div>
            <div class="row no-gutters align-items-center">
              <div class="col-auto">
                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                <?= count($this->db->get('peminjaman')->result_array()) - count($this->db->get_where('peminjaman', ['status' => '-'])->result_array()); ?>
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
              $nullPoli = count($this->db->get_where('poli', ['nama_poli' => '-'])->result_array());
              $allPoli = count($this->db->get('poli')->result_array());
              echo $allPoli - $nullPoli;
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fas fa-hospital fa-2x text-gray-300"></i>
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

