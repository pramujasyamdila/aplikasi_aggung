<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="section-body" style="background-color: white;">
            <div class="row p-2">
                <div class="col-md-1">

                </div>
                <div class="col-md-5">
                    <p>PT. Global Evolusi Teknologi </p>
                    <p>Cibarengkok No 6 Pengasinan Gunung Sindur</p>
                    <p>Kab. Bogor Jawa Barat 16340</p>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-2">
                    <img width="250px" src="<?= base_url('assets/gain.png') ?>" alt="">
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div style="background-color: black; width:100%;height:2px">
            </div>
            <br>
            <center>
                <h4>
                    Formulir Pendaftaran Berlangganan <br>
                    Koneksi Internet Get-Link
                </h4>
            </center>
            <br><br>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <label for=""> Data Pelanggan</label>
                </div>
                <div class="col-md-6">
                    <label for=""></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <label for=""> Nama (Sesuai KTP)</label>
                </div>
                <div class="col-md-6">
                    <label for="">: <?= $row_user['nama_user'] ?></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <label for=""> Alamat Pemasangan</label>
                </div>
                <div class="col-md-6">
                    <label for="">: <?= $row_user['alamat'] ?></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <label for=""> Telp</label>
                </div>
                <div class="col-md-6">
                    <label for="">: <?= $row_user['telepone'] ?></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <label for=""> Email</label>
                </div>
                <div class="col-md-6">
                    <label for="">:  <?= $row_user['email'] ?></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-2">
                    <label for=""> Paket Pilihan</label>
                </div>
                <div class="col-md-6">
                    <label for=""></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row p-3">
                <div class="col-md-1">

                </div>
                <div class="col-md-6">
                    <label for=""> <i class="fas fa fa-check"></i> Biaya Aktivasi</label>
                </div>
                <div class="col-md-2">
                    <label for=""> Rp.200.00</label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-6">
                    <label for=""> <i class="fas fa fa-check"></i> <?= $row_user['nama_paket_bulanan'] ?></label>
                </div>
                <div class="col-md-2">
                    <label for=""> <?= "Rp " . number_format($row_user['harga_paket_bulanan'], 2, ',', '.') ?></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-4">
                    <label for=""> Pembayaran Sewa Bulanan</label>
                </div>
                <div class="col-md-4">
                    <label for=""></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-6">
                    <label for=""> <i class="fas fa fa-check"></i> <?= $row_user['tipe_pembayaran_bulanan'] ?></label>
                </div>
                <div class="col-md-2">
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <br><br>
            <div class="row p-3">
                <div class="col-md-1">

                </div>
                <div class="col-md-4">
                    <label for=""> Syarat dan Ketentuan Berlangganan :</label>
                </div>
                <div class="col-md-4">
                    <label for=""></label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-11">
                    <label for="">1. Pelanggan melampirkan Kartu Tanda Pengenal (KTP) yang masih berlaku</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-11">
                    <label for="">2. Sistem Berlangganan bersifat PRABAYAR, dimana pembayaran dilakukan di Muka</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-11">
                    <label for="">3. Pembayaran Jatuh Tempo setiap Tanggal 25-2 Setiap bulannya</label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-10">
                    <label for="">4. Pihak PT. Global Evolusi Teknologi atau Get-Link akan melakukan pemutusan sepihak
                        apabila pelanggan tidak melakukan Pembayaran sampai waktu yang telah di tentukan</label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-10">
                    <label for="">5. Biaya Aktivasi merupakan Biaya Sewa Pakai Perangkat, berupa : WIFI Outdoor dan
                        Instalasi LAN. Pihak PT. Global Evolusi Teknologi akan memberikan Garansi bila terjadi
                        kerusakan pada alat (Garansi tidak berlaku bila kerusakan disebabkan kelalaian
                        konsumen), Perangkat akan di ambil kembali bila Pelanggan Berhenti Berlangganan</label>
                </div>
                <div class="col-md-1">

                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-md-1">

                </div>

                <div class="col-md-5">
                    <center><br>
                        <label for="">Sales</label>
                        <br><br><br>
                        (<?= $row_user['nama_sales'] ?>)
                    </center>

                </div>

                <div class="col-md-5">
                    <center>
                        Bogor, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 2023 <br>
                        <label for="">Pelanggan</label>
                        <br><br><br>
                        (<?= $row_user['nama_user'] ?>)
                    </center>
                </div>

                <div class="col-md-1">

                </div>
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-1">

                </div>
                <div class="col-md-11">
                    Catatan :
                </div>
            </div>
            <br><br><br><br>
        </div>
    </section>
    <!-- start modal -->
    <!-- end batas modal -->

</div>