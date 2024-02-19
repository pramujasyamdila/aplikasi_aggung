<!-- Main Content -->
<?php

function terbilang($x)
{
    $angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

    if ($x < 12)
        return " " . $angka[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . " Belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return "Seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return "Seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
}
?>
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="section-body" style="background-color: white;">
            <div class="row p-2">
                <div class="col-md-2">
                    <img width="200px" src="<?= base_url('assets/gain.png') ?>" alt="">
                </div>
                <div class="col-md-4">
                    <p>PT. Global Evolusi Teknologi </p>
                    <p>Cibarengkok No 6 Pengasinan Gunung Sindur</p>
                    <p>Kab. Bogor Jawa Barat 16340</p>
                </div>
                <div class="col-md-1">
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-1">
                    <label style="font-weight: bold;margin-top:100px" for="">INVOICE</label>
                </div>
            </div>
            <div style="background-color: black; width:100%;height:2px">
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-5">
                    <label for=""> Bill To :</label> <br>
                    <label for="">Yth. Bpk/Ibu <?= $row_user['nama_user'] ?> (<?= $row_user['telepone'] ?>)</label> <br>
                    <label for=""><?= $row_user['alamat'] ?> <?= $row_user['nama_lokasi'] ?></label>
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-1">
                    <label for=""> No.Invoice </label> <br>
                    <label for=""> Date </label> <br>
                    <label for=""> Revision </label> <br>
                    <label for=""> CustomerID </label> <br>
                    <label for=""> Date </label> <br>
                </div>
                <div class="col-md-3">
                    <label for=""> : 04/AI-MM/GET-INV/VII/2023 </label> <br>
                    <label for=""> : <?= $row_user['date_create'] ?> </label> <br>
                    <label for=""> : </label> <br>
                    <label for=""> : GET/2023/0026 (<?= $row_user['kode_referal'] ?>)</label> <br>
                    <label for=""> : <?= $row_user['date_create'] ?> </label> <br>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-1">

                </div>
                <div class="col-md-10">
                    <table class="table">
                        <thead class="bg-primary">
                            <tr>
                                <th class="text-white">NO</th>
                                <th class="text-white">DESCRIPTION</th>
                                <th class="text-white">QTY</th>
                                <th class="text-white">UOM</th>
                                <th class="text-white">UNIT PRICE</th>
                                <th class="text-white">TOTAL PRICE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td><?= $row_user['nama_paket_bulanan'] ?></td>
                                <td>1</td>
                                <td>Site</td>
                                <td><?= "Rp " . number_format($row_user['harga_paket_bulanan'], 2, ',', '.') ?></td>
                                <td><?= "Rp " . number_format($row_user['harga_paket_bulanan'], 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" rowspan="3">Note : Jatuh Tempo 5 Hari Setelah Invoice Di terima</td>
                                <td>Sub Total</td>
                                <td><?= "Rp " . number_format($row_user['harga_paket_bulanan'], 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?= "Rp " . number_format($row_user['harga_paket_bulanan'], 2, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td colspan="6">Terbilang : <?= terbilang($row_user['harga_paket_bulanan']) ?> Rupiah</td>
                            </tr>
                            <?php
                            $time = strtotime($row_user['date_create']);
                            $final = date("Y-m-d", strtotime("+1 month", $time));
                            ?>
                            <tr>
                                <td colspan="6">Due Date : <?= $final ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-3">
                    <label for=""> Please Transfer To :</label><br>
                    <label for=""> PT GLOBAL EVOLUSI TEKNOLOGI</label><br>
                    <label for=""> BANK BRI CAB. BUMI SERPONG DAMAI</label><br>
                    <label for=""> ACCOUNT NO : 0509-01-002702-30-9</label><br>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-3">
                    <center><br>
                        <label for="">Approved By :</label>
                        <br><br><br>
                        (Khunti Widyati)
                    </center>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <br><br><br><br>
        </div>
    </section>
    <!-- start modal -->
    <!-- end batas modal -->

</div>