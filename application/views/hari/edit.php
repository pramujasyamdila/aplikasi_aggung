<!-- Main Content -->
<!-- hari -->
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
                            <h4 class="text-white">EDIT hari</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_hari['id_hari']?>" name="id_hari" required class="form-control" placeholder="Nama hari...">

                                        <div class="form-group">
                                            <label for="">Nama hari</label>
                                            <input type="text" value="<?= $row_hari['nama_hari']?>" name="nama_hari" required class="form-control" placeholder="Nama hari...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode hari</label>
                                            <input type="text" value="<?= $row_hari['kode_hari']?>" name="kode_hari" required class="form-control" placeholder="Kode hari">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('genetika/hari')?>" class="btn btn-secondary">Kembali</a>
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