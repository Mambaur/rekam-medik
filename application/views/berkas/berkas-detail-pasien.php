
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Detail berkas pasien</h1>
</div>

<!-- Basic Card Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <!-- Nested Row within Card Body -->
        <form class="user">
            <div class="row">
                <div class="col-lg-6">
                    <div class="p-5">
                        
                            <div class="row d-flex justify-content-between mx-1">
                                <div class="form-group">
                                    <input type="text" name="norm" class="form-control form-control-user" placeholder="Nomor rekam medik...">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="nik" class="form-control form-control-user" placeholder="NIK pasien...">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="nama-pasien" class="form-control form-control-user" placeholder="Nama pasien...">
                            </div>

                            <div class="form-group">
                                <input type="text" name="alamat" class="form-control form-control-user" placeholder="Alamat...">
                            </div>
                            <div class="my-1 ml-1">Jenis Kelamin</div>
                            <div class="btn-group ml-1" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" name="jk" autocomplete="off" checked> Laki-laki
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" name="jk" autocomplete="off"> Perempuan
                                </label>
                            </div>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="py-5 pr-5">
                        <div class="form-group">
                            <input type="text" name="norak" class="form-control form-control-user" placeholder="Nomor Rak...">
                        </div>
                        <div class="row mx-1">
                            <div class="form-group mx-1 w-50">
                                Nama Distributor
                                <select class="form-control" name="distributor">
                                <option value="1" selected>Agus</option>
                                <option value="1">Andi</option>
                                <option value="1">Jomb</option>
                                </select>
                            </div>
                            <div class="form-group mx-1">
                                Nama Poli
                                <select class="form-control" name="distributor">
                                <option value="1" selected>Poli Gigi</option>
                                <option value="1">Andi</option>
                                <option value="1">Jomb</option>
                                </select>
                            </div>
                            <div class="form-group w-100">
                                <label for="keterangan">Keterangan</label>
                                <textarea class="form-control form-control-user" name="keterangan" id="keterangan" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="d-flex justify-content-center mt-1 mb-5">
    <a href="<?= base_url();?>berkas/" class="btn btn-secondary btn-icon-split mr-1">
        <span class="icon text-white-50">
        <i class="fas fa-arrow-left"></i>
        </span>
        <span class="text">Kembali</span>
    </a>
    <a href="#" class="btn btn-success btn-icon-split">
        <span class="icon text-white-50">
        <i class="fas fa-check"></i>
        </span>
        <span class="text">Perbarui Data Pasien</span>
    </a>
</div>