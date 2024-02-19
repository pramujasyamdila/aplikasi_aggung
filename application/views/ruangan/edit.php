<!-- Main Content -->
<!-- ruangan -->
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
                            <h4 class="text-white">EDIT ruangan</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_ruangan['id_ruangan']?>" name="id_ruangan" required class="form-control" placeholder="Nama ruangan...">

                                        <div class="form-group">
                                            <label for="">Nama ruangan</label>
                                            <input type="text" value="<?= $row_ruangan['nama_ruangan']?>" name="nama_ruangan" required class="form-control" placeholder="Nama ruangan...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode ruangan</label>
                                            <input type="text" value="<?= $row_ruangan['kode_ruangan']?>" name="kode_ruangan" required class="form-control" placeholder="Kode ruangan">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('genetika/ruangan')?>" class="btn btn-secondary">Kembali</a>
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