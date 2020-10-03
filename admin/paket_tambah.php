<?php
$title = 'paket';
require'functions.php';
$query = 'SELECT * FROM outlet';
$data = ambildata($conn,$query);

if(isset($_POST['btn-simpan'])){
    $nama   = stripslashes($_POST['nama_paket']);
    $jenis_paket = stripslashes($_POST['jenis_paket']);
    $harga   = stripslashes($_POST['harga']);
    $outlet_id   = stripslashes($_POST['outlet_id']);

    $query = "INSERT INTO paket (nama_paket,jenis_paket,harga,outlet_id) values ('$nama','$jenis_paket','$harga','$outlet_id')";
    
    $execute = bisa($conn,$query);
    if($execute == 1){
        $success = 'true';
        $title = 'Berhasil';
        $message = 'Berhasil Simpan Data';
        $type = 'success';
        header('location: paket.php?crud='.$success.'&msg='.$message.'&type='.$type.'&title='.$title);
    }else{
        echo "Gagal Tambah Data";
    }
}


require'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master <?= htmlspecialchars($title); ?></h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php"><?= htmlspecialchars($title); ?></a></li>
                <li><a href="#">Tambah <?= htmlspecialchars($title); ?></a></li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-6">
                          <a href="javascript:void(0)" onclick="window.history.back();" class="btn btn-primary box-title"><i class="fa fa-arrow-left fa-fw"></i> Kembali</a>
                    </div>
                    <div class="col-md-6 text-right">
                        <button id="btn-refresh" class="btn btn-primary box-title text-right" title="Refresh Data"><i class="fa fa-refresh" id="ic-refresh"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="white-box">
                <form method="post" action="">
                <div class="form-group">
                    <label>Nama Paket</label>
                    <input type="text" name="nama_paket" class="form-control">
                </div>
                <div class="form-group">
                    <label>Jenis Paket</label>
                    <select name="jenis_paket" class="form-control">
                        <option value="kiloan">kiloan</option>
                        <option value="selimut">selimut</option>
                        <option value="bedcover">bedcover</option>
                        <option value="kiloan">kiloan</option>
                        <option value="kaos">kaos</option>
                        <option value="lain">lain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input type="text" name="harga" class="form-control">
                </div>
                <div class="form-group">
                    <label>Pilih Outlet</label>
                    <select name="outlet_id" class="form-control">
                        <?php foreach ($data as $outlet): ?>
                            <option value="<?= $outlet['id_outlet'] ?>"><?= htmlspecialchars($outlet['nama_outlet']); ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="text-right">
                    <button type="reset" class="btn btn-danger">Reset</button>
                    <button type="submit" name="btn-simpan" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require'layout_footer.php';
?> 
