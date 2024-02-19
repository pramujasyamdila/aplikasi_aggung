<!-- Main Content -->
<!-- waktu -->
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
                            <h4 class="text-white">EDIT waktu</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_waktu['id_waktu']?>" name="id_waktu" required class="form-control" placeholder="Nama waktu...">

                                        <div class="form-group">
                                            <label for="">Nama waktu</label>
                                            <input type="text" value="<?= $row_waktu['nama_waktu']?>" name="nama_waktu" required class="form-control" placeholder="Nama waktu...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode waktu</label>
                                            <input type="text" value="<?= $row_waktu['kode_waktu']?>" name="kode_waktu" required class="form-control" placeholder="Kode waktu">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('genetika/waktu')?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- start modal -->
    <!-- end batas modal -->

</div>
</div>