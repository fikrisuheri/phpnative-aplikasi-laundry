<?php
$title = 'pengguna';
require'functions.php';
$tgl_sekarang = Date('Y-m-d h:i:s');
$tujuh_hari   = mktime(0,0,0,date("n"),date("j")+7,date("Y"));
$batas_waktu  = date("Y-m-d h:i:s", $tujuh_hari);



$invoice   = 'DRY'.Date('Ymdsi');
$outlet_id = $_GET['outlet_id'];
$user_id   = $_SESSION['user_id']; 
$member_id = $_GET['id'];

$outlet = ambilsatubaris($conn,'SELECT nama_outlet from outlet WHERE id_outlet = ' . $outlet_id);
$member = ambilsatubaris($conn,'SELECT nama_member from member WHERE id_member = ' . $member_id);
$paket = ambildata($conn,'SELECT * FROM paket WHERE outlet_id = ' . $outlet_id);
if(isset($_POST['btn-simpan'])){   
    $kode_invoice = $_POST['kode_invoice'];
    $biaya_tambahan = $_POST['biaya_tambahan'];
    $diskon = $_POST['diskon'];
    $pajak = $_POST['pajak'];
    
    $query = "INSERT INTO transaksi (outlet_id,kode_invoice,member_id,tgl,batas_waktu,biaya_tambahan,diskon,pajak,status,status_bayar,user_id) VALUES ('$outlet_id','$kode_invoice','$member_id','$tgl_sekarang','$batas_waktu','$biaya_tambahan','$diskon','$pajak','baru','belum','$user_id')";

    $execute = bisa($conn,$query);
    if ($execute == 1) {
        $paket_id = $_POST['paket_id'];
        $qty = $_POST['qty'];
        $hargapaket = ambilsatubaris($conn,'SELECT harga from paket WHERE id_paket = ' . $paket_id);
        $total_harga = $hargapaket['harga'] * $qty;
        $kode_invoice;
        $transaksi = ambilsatubaris($conn,"SELECT * FROM transaksi WHERE kode_invoice = '" . $kode_invoice ."'");
        $transaksi_id = $transaksi['id_transaksi'];
            
        $sqlDetail = "INSERT INTO detail_transaksi (transaksi_id,paket_id,qty,total_harga) VALUES ('$transaksi_id','$paket_id','$qty','$total_harga')";

        $executeDetail = bisa($conn,$sqlDetail);
        if($executeDetail == 1){
            header('location: transaksi_sukses.php?id='.$transaksi_id);
        }else{
            echo "Gagal Tambah Data";
        }
    }
    
}


require'layout_header.php';
?> 
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">Data Master Transaksi</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="outlet.php">Transaksi</a></li>
                <li><a href="#">Tambah Transaksi</a></li>
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
                    <label>Kode Invoice</label>
                    <input type="text" name="kode_invoice" class="form-control" readonly="" value="<?= $invoice ?>">
                </div>
                <div class="form-group">
                    <label>Outlet</label>
                    <input type="text" name="username" class="form-control" readonly="" value="<?= $outlet['nama_outlet'] ?>">
                </div>
                <div class="form-group">
                    <label>Pelanggan</label>
                    <input type="text" name="password" class="form-control" readonly="" value="<?= $member['nama_member'] ?>"> 
                </div>
                <div class="form-group">
                    <label>Pilih Paket</label>
                    <select name="paket_id" class="form-control">
                        <?php foreach ($paket as $key): ?>
                            <option value="<?= $key['id_paket'] ?>"><?= $key['nama_paket'];  ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="text" name="qty" class="form-control"> 
                </div>
                <div class="form-group">
                    <label>Biaya Tambahan</label>
                    <input type="text" name="biaya_tambahan" class="form-control" value="0"> 
                </div>
                <div class="form-group">
                    <label>Diskon (%)</label>
                    <input type="text" name="diskon" class="form-control" value="0"> 
                </div>
                <div class="form-group">
                    <label>Pajak</label>
                    <input type="text" name="pajak" class="form-control" value="0"> 
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