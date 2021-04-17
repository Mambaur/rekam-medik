
<form action="<?= base_url('pesan/telegram');?>" method="post">
    <div class="row">
        <div class="col-lg-7 mx-auto">
        <?= $this->session->flashdata('message'); ?>
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="mx-2 my-1 text-center">Kirim ke</div>
                        <div style="width:69%" class="form-group mr-2">
                            <select class="form-control" name="telepon">
                                <?php foreach($poli as $item){ 
                                    if ($item['id_poli'] != 1) {
                                        echo '<option value="'.$item['telepon'].'">'.$item['nama_poli'].'</option>';
                                    }
                                }?>
                            </select>
                        </div>
                    </div>
                    <div class="bg-dark py-2 px-2" id="scroll" style="overflow:scroll; height:500px;">
                        <?php foreach ($tbpesan as $item){ ?>
                        <div class="card <?php if($item['tipe'] == 'Terima'){echo 'border-left-success';}else{echo 'border-left-primary';} ?> shadow h-10 mb-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1"><?= $item['subjek'].' | id:'.$item['id_userMessage']  ?></div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800"><?= $item['isi_pesan'] ?></div><?= $item['time'] ?>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn <?php if($item['tipe'] == 'Terima'){echo 'btn-success';}else{echo 'btn-primary';} ?>  btn-circle">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <script>
                        var objDiv = document.getElementById("scroll");
                        objDiv.scrollTop = objDiv.scrollHeight;
                    </script>
                    <div class="row d-flex justify-content-center mt-2">
                        <div class="form-group mr-2 w-75">
                            <textarea class="form-control" name="pesan" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-icon-split h-25">
                            <span class="icon text-white-50">
                            <i class="fas fa-paper-plane"></i>
                            </span>
                            <span class="text">Kirim</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>