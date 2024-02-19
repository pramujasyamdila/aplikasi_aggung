<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/build/css/custom.min.css" rel="stylesheet">
    <title>JMTM DOKUMEN LOGIN</title>
</head>
<div class="container">
    <div class="card">
        <div class="card-header">
            PEMBAYARAN
        </div>
        <div class="card-body">
            <form action="<?= base_url('pemesanan/kirim') ?>" method="post">
                <div class="form-group">
                    <label for="">External Id</label>
                    <input type="text" name="external_id" class="form-control" placeholder="External Id">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="keterangan">
                </div>
                <div class="form-group">
                    <label for="">Nama Customer</label>
                    <input type="text" name="nama_customer" class="form-control" placeholder="Nama Customer">
                </div>
                <div class="form-group">
                    <label for="">No Telpon</label>
                    <input type="text" name="no_telpon" class="form-control" placeholder="No.Telpon">
                </div>
                <!-- items -->
                <div class="form-group">
                    <label for="">Voucher</label>
                    <input type="text" name="nama_voucher" class="form-control" placeholder="Voucher">
                </div>
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="text" name="harga" class="form-control" placeholder="Harga">
                </div>
                <div class="form-group">
                    <label for="">Jumlah</label>
                    <input type="text" name="jumlah" class="form-control" placeholder="Jumlah">
                </div>
                <button type="submit" class="btn btn-sm btn-success">Kirim</button>
            </form>
        </div>
    </div>
</div>

</html>