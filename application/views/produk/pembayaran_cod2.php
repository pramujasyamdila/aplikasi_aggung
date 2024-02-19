<div class="invoice-1 invoice-content" style="background-color: white;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <label style="font-size: 10px;" class="color-white inv-header-1">Pemesan</label>
                                    <p style="font-size: 10px;" class="color-white mb-1">Nama Pemesan <span><?= $row_detail_produk['nama_pemesan'] ?></span></p>
                                    <p style="font-size: 10px;" class="color-white mb-0">Nomor Pemesan <span><?= $row_detail_produk['telepon_pemesan'] ?></span></p>
                                    <label style="font-size: 10px;" class="color-white inv-header-1">Pemesan</label>
                                    <p style="font-size: 10px;" class="color-white mb-1">Status Pembayaran : 
                                        <?php if ($row_detail_produk['sts_pembayaran'] == 'PAID') { ?>
                                            <span class="text-success"> Sudah Bayar </span>
                                        <?php  } else { ?>
                                            <span class="text-danger"> Belum Bayar </span>
                                        <?php  }
                                        ?>

                                    </p>
                                    <!-- logo ended -->
                                </div>
                                <div class="col-md-4">
                                    <label style="font-size: 10px;" class="color-white inv-header-1">No Order</label>
                                    <p style="font-size: 10px;" class="color-white mb-1">Invoice Number <span><?= $row_detail_produk['no_order'] ?></span></p>
                                    <p style="font-size: 10px;" class="color-white mb-0">Invoice Date <span><?= $row_detail_produk['waktu_order'] ?></span></p>
                                    <!-- logo ended -->
                                </div>
                                <div class="col-sm-4">
                                    <div class="invoice-logo">
                                        <!-- logo started -->
                                        <div class="logo">
                                            <img style="width: 100px;" src="https://kiosonlineshop.com/image/cache/data/toko-online-250x250.jpg" alt="logo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <style>
                            table,
                            th,
                            td {
                                border: 1px solid black;
                                border-collapse: collapse;
                            }
                        </style>

                        <div class="invoice-center">
                            <div class="table-responsive">
                                <br>
                                <table id="example" class="table">
                                    <thead class="bg-active">
                                        <tr class="tr">
                                            <th style="font-size: 10px;">No.</th>
                                            <th style="font-size: 10px;" class="pl0 text-start">Nama Hotel</th>
                                            <th style="font-size: 10px;" class="pl0 text-start">Kamar</th>
                                            <th style="font-size: 10px;" class="text-center">Harga Kamar</th>
                                            <th style="font-size: 10px;" class="text-center">Quantity</th>
                                            <th style="font-size: 10px;" class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($result_detail_produk as $key => $value) { ?>
                                            <tr class="tr">
                                                <td style="font-size: 10px;"><?= $no++ ?></td>
                                                <td style="font-size: 10px;" class="pl0 text-start"><?= $value['nama_hotel'] ?></td>
                                                <td style="font-size: 10px;" class="pl0 text-start"><?= $value['nama_produk'] ?></td>
                                                <td style="font-size: 10px;" class="pl0 text-start"><?= "Rp " . number_format($value['harga_produk'], 2, ',', '.') ?></td>
                                                <td style="font-size: 10px;" class="pl0 text-start"><?= $value['jumlah_pesanan'] ?></td>
                                                <td style="font-size: 10px;" class="pl0 text-start"><?= "Rp " . number_format($value['harga_produk'] *  $value['jumlah_pesanan'], 2, ',', '.') ?></td>
                                            </tr>
                                        <?php   } ?>
                                        <tr class="tr2">
                                            <td style="font-size: 10px;"></td>
                                            <td style="font-size: 10px;"></td>
                                            <td style="font-size: 10px;"></td>
                                            <td style="font-size: 10px;"></td>
                                            <td style="font-size: 10px;" class="text-center f-w-600 active-color">Grand Total</td>
                                            <td style="font-size: 10px;" class="f-w-600 text-end active-color"><?= "Rp " . number_format($row_detail_produk['total_pesanan'], 2, ',', '.') ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    new DataTable('#example');
</script>