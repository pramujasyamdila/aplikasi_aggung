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
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Update</h4>
                    </div>
                    <form action="<?= base_url('master_data/update'); ?>" method="post">
                        <input type="hidden" name="id" value="<?= $paket->id_paket_bulanan_pilihan; ?>">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama_paket_bulanan">Nama Paket Bulanan</label>
                                <input type="text" class="form-control" name="nama_paket_bulanan" id="nama_paket_bulanan" value="<?= $paket->nama_paket_bulanan; ?>" required>
                            </div>

                            <div class=" form-group">
                                <label for="harga_paket_bulanan">Harga Paket Bulanan</label>
                                <input type="number" class="form-control" name="harga_paket_bulanan" id="harga_paket_bulanan" value="<?= $paket->harga_paket_bulanan; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-info" value="Simpan">Update</button>
                        </div>
                    </form>
                </div>
    </section>
    <!-- start modal -->
    <!-- end batas modal -->

</div>