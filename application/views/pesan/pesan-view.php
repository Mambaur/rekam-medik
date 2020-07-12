
<!-- Page Heading -->
<!-- <div class="d-sm-flex align-items-center justify-content-center mb-4">
  <h1 class="h3 mb-0 text-gray-800">Pesan</h1>
</div> -->

<div class="row">
<div class="col-lg-7 mx-auto">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="mx-2 my-1 text-center">Kirim ke</div>
                    <div style="width:69%" class="form-group mr-2">
                        <select class="form-control" name="poli">
                            <?php foreach($poli as $item){ 
                                if ($item['id_poli'] != 1) {
                                    echo '<option value="'.$item['telepon'].'">'.$item['nama_poli'].'</option>';
                                }
                            }?>
                        </select>
                    </div>
                </div>
                <div class="bg-dark py-4 px-2">
                    <div class="card border-left-success shadow h-10 mb-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paidin</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Minta pengiriman poli</div>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-success btn-circle">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-left-success shadow h-10 mb-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paidin</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Minta pengiriman poli</div>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-success btn-circle">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-left-success shadow h-10 mb-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paidin</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Minta pengiriman poli</div>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-success btn-circle">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-left-success shadow h-10 mb-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paidin</div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800">Minta pengiriman poli</div>
                                </div>
                                <div class="col-auto">
                                    <a href="#" class="btn btn-success btn-circle">
                                        <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-4">
                    <div class="form-group mr-2 w-75">
                        <textarea class="form-control" name="pesan" rows="2"></textarea>
                    </div>
                    <a href="#" class="btn btn-success btn-icon-split h-25">
                        <span class="icon text-white-50">
                        <i class="fa fa-rocketchat"></i>
                        </span>
                        <span class="text">Kirim</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>