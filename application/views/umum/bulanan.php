<!-- Main Content -->
<div class="main-content">
    <section class="section">

        <div class="alert alert-warning alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <?= $title ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pelanggan Aktif</h4>
                        </div>
                        <div class="card-body">
                            <h4> <?php echo $jml_aktif; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-user-minus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pelanggan Non Aktif</h4>
                        </div>
                        <div class="card-body">
                            <h4> <?php echo $jml_non; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Pelanggan</h4>
                        </div>
                        <div class="card-body">
                            <h4> <?php echo $jml_all; ?></h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>



        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header text-white" style="position: left;">
                            <!-- <h4 class="text-white">DATA PELANGGAN PAKET BULANAN</h4> -->
                            <div class="col-md-3">
                                <select name="status" class="form-control" id="">
                                    <option value="1">--Pilih Area--</option>
                                    <option value=""></option>
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="card-header-action">
                                <!-- <a href="javascript:;" data-toggle="modal" data-target="#modal_tambah" class="btn btn-success">
                                    <i class="fas fa fa-plus"></i> Tambah
                                </a> -->
                                <a href="" class="btn btn-dark"><i class="fas fa-filter"></i> Filter</a>
                                <a href="javascript:;" data-toggle="modal" data-target="#modal_tambah" class="btn btn-success"><i class="fas fa-plus-square"></i> Tambah</a>
                                <a href="#" class="btn btn-icon icon-left btn-danger"><i class="fas fa-file-pdf"></i> PDF</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="table_bulanan" class="table">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Status</th>
                                            <th class="text-white">Nama</th>
                                            <th class="text-white">Telepon</th>
                                            <th class="text-white">Email</th>
                                            <th class="text-white">Alamat</th>
                                            <th class="text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- start modal -->
    <!-- end batas modal -->

</div>
<div class="modal fade" id="modal_tambah" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="javascript:;" id="form_tambah" method="post">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Pelanggan Bulanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama_user" required class="form-control" placeholder="Nama Pelanggan Bulanan Sesuai Ktp...">
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input type="text" name="telepone" required class="form-control" placeholder="Ex: 089782010...">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" required class="form-control" placeholder="Ex: gain@gmail.com...">
                        </div>
                        <div class="form-group">
                            <label for="">Lokasi Pemasangan</label>
                            <select name="id_lokasi" class="form-control" id="">
                                <?php foreach ($result_lokasi as $key => $value) { ?>
                                    <option value="<?= $value['id_lokasi'] ?>"><?= $value['nama_lokasi'] ?></option>
                                <?php   } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat Pemasangan</label>
                            <textarea type="text" name="alamat" required class="form-control" placeholder="Ex: Alamat Pemasangan..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Paket Pilihan</label>
                            <select name="id_paket_bulanan_pilihan" class="form-control" id="">
                                <?php foreach ($result_paket_pilihan_bulanan as $key => $value) { ?>
                                    <option value="<?= $value['id_paket_bulanan_pilihan'] ?>"><?= $value['nama_paket_bulanan'] . ' || ' . "Rp " . number_format($value['harga_paket_bulanan'], 2, ',', '.'); ?></option>
                                <?php   } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Pembayaran Sewa Bulanan</label>
                            <select name="tipe_pembayaran_bulanan" class="form-control" id="">
                                <option value="Transfer melalui rekening : BNI 1582188912 A/n PT.Global Evolusi Teknologi">Transfer melalui rekening : BNI 1582188912 A/n PT.Global Evolusi Teknologi</option>
                                <option value="Cash Pada pegawai GET ( resmi )">Cash Pada pegawai GET ( resmi )</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="1">Active</option>
                                <option value="2">Non Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Foto Pelanggan / Bukti</label>
                            <input type="file" onchange="readURL(this)" name="file" class="form-control" placeholder="" aria-describedby="helpId">
                            <center>
                                <br>
                                <img style="width: 200px;" class="image_view" src="<?= base_url('assets/image/vire.jpg') ?>" alt="your image" />
                            </center>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Sales</label>
                            <input type="text" name="nama_sales" required class="form-control" placeholder="Nama Sales...">
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" required class="form-control" placeholder="Ex: Pramsco...">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" required class="form-control" placeholder="Ex: ****...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                </div>
        </form>
    </div>
    <!-- Modal -->
</div>
</div>

<div class="modal fade" id="modal_cek_riwayat" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">RIWAYAT PEMBAYARAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Deskripsi Pembayaran</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td>Pembayaran Aktivasi Registrasi</td>
                            <td><label for="" class="badge badge-success"> Sudah Bayar</label></td>
                            <td><a href="javascript:;" onclick="lihat_pembayaran()" class="btn btn-success"> Cek Pembayaran</a></td>
                        </tr>
                        <tr>
                            <td scope="row">2</td>
                            <td>Pembayaran Bulanan</td>
                            <td><label for="" class="badge badge-danger"> Belum Bayar</label></td>
                            <td><a href="javascript:;" onclick="lihat_pembayaran()" class="btn btn-success"> Cek Pembayaran</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lihat_pembayaran" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">BUKTI PEMBAYARAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="token_notif" name="token_notif">
                <center>
                    <h3>
                        INI MERUPAKAN BUKTI PEMBAYARAN
                    </h3>
                </center>
                <br>
                <center>
                    <div>
                        <img src="<?= base_url('assets/gainbaru.jpg') ?>" width="200px" alt="">
                    </div>
                </center>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="javascript:;" onclick="kirim_notif()" class="btn btn-success"> Approve</a>
            </div>
        </div>
    </div>
</div>