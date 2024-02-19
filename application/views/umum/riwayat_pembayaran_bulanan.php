<!-- Main Content -->
<input type="hidden" value="<?= $row_user['id_user'] ?>" class="id_user">
<input type="hidden" id="id_riwayat_pemabayaran">
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="text-white">DATA PELANGGAN PAKET BULANAN</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" readonly value="<?= $row_user['nama_user'] ?>" name="nama_user" required class="form-control" placeholder="Nama Pegawai...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Telepon</label>
                                        <input type="text" readonly value="<?= $row_user['telepone'] ?>" name="telepone" required class="form-control" placeholder="Ex: 089782010...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" readonly value="<?= $row_user['email'] ?>" name="email" required class="form-control" placeholder="Ex: gain@gmail.com...">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Alamat</label>
                                        <textarea type="text" readonly name="alamat" required class="form-control" placeholder="Ex: Rawakalong..."><?= $row_user['alamat'] ?></textarea>
                                    </div>
                                </div>
                            </div>



                            <br><br>
                            <div class="row">
                                <table id="table_riwayat_pembayaran_bulanan" class="table">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Jenis Taggihan Pembayaran</th>
                                            <th class="text-white">Tanggal Harus Di Bayar</th>
                                            <th class="text-white">Status Pembayaran</th>
                                            <th class="text-white">Total Pembayaran</th>
                                            <th class="text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
    <!-- Modal -->
    <div class="modal fade" id="modal_informasi_signal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Taggihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="javascript:;" id="form_informasi_signal" method="post">
                        <input type="hidden" name="id_user">
                        <div class="form-group">
                            <label for=""></label>
                            <textarea name="informasi_signal" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="kirim_iformasi_signal()" type="button" class="btn btn-primary">Kirim</button>
                </div>
            </div>
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
                <form action="javascript:;" id="form_informasi_signal2" method="post">
                    <input type="hidden" name="id_user">
                    <input type="hidden" id="token_notif" name="token_notif">
                    <div class="form-group">
                        <label for=""></label>
                        <input type="hidden" id="informasi_signal" name="informasi_signal">
                    </div>
                </form>
                <center>
                    <h3>
                        INI MERUPAKAN BUKTI PEMBAYARAN
                    </h3>
                </center>
                <br>
                <center>
                    <div class="result_image">

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