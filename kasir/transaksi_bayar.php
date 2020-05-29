<?php
$title = 'transaksi';
require'functions.php';
$query = 'SELECT transaksi.*,member.nama_member , detail_transaksi.total_harga FROM transaksi INNER JOIN member ON member.id_member = transaksi.member_id INNER JOIN detail_transaksi ON detail_transaksi.transaksi_id = transaksi.id_transaksi WHERE transaksi.id_transaksi = ' . $_GET['id'];
$data = ambilsatubaris($conn,$query);
if(isset($_POST['btn-simpan'])) {
    $total_bayar = $_POST['total_bayar'];
    if($total_bayar >= $data['total_harga']){
        $query = "UPDATE transaksi SET status_bayar = 'dibayar',tgl_pembayaran = '" . Date('Y-m-d h:i:s') . "' WHERE id_transaksi = " . $_GET['id'];
        $query2 = "UPDATE detail_transaksi SET total_bayar = '$total_bayar' WHERE transaksi_id = " . $_GET['id'];
        $execute = bisa($conn,$query);
        $execute2 = bisa($conn,$query2);
        if($execute == 1 && $execute2 == 1){
            echo "<script>alert('OK');</script>";
            header('location:transaksi_telah_dibayar.php?id='.$_GET['id']);
        }else{
            echo "Gagal Tambah Data";
        }   
    }else{
        $message = "Jumlah Uang Pembayaran Kurang";
        header('location:transaksi_bayar.php?id='.$_GET['id']. '&msg='.$message);
    }
}


require'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master <?= $title ?></h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php"><?= $title ?></a></li>
                <li><a href="#">Konfirmasi Pembayaran <?= $title ?></a></li>
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
                <form method="post" action="transaksi_bayar.php?id=<?= $data['id_transaksi'] ?>" id="form-submit">
                <div class="form-group">
                    <label>Kode Invoice</label>
                    <input type="text" name="kode_invoice" value="<?= $data['kode_invoice'] ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Member</label>
                    <input type="text" name="nama_member" value="<?= $data['nama_member'] ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Total Yang Harus Di Bayar</label>
                    <input type="text" name="total_harga" value="<?= $data['total_harga'] ?>" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label>Masukan Jumlah Pembayaran</label>
                    <input type="number" name="total_bayar" id="total_bayar"  class="form-control">
                    <?php if (isset($_GET['msg'])): ?>
                        <small class="text-danger"><?= $_GET['msg'] ?></small>
                    <?php endif ?>
                </div>
                <div class="text-right">
                    <button type="submit" name="btn-simpan" id="btn-simpan" class="btn btn-primary">Bayar</utton>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require'layout_footer.php';
?> 
