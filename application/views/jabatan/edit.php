<!-- Main Content -->
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
                            <h4 class="text-white">EDIT JABATAN</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_jabatan['id_jabatan']?>" name="id_jabatan" required class="form-control" placeholder="Nama Jabatan...">

                                        <div class="form-group">
                                            <label for="">Nama Jabatan</label>
                                            <input type="text" value="<?= $row_jabatan['nama_jabatan']?>" name="nama_jabatan" required class="form-control" placeholder="Nama Jabatan...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode Jabatan</label>
                                            <input type="text" value="<?= $row_jabatan['kode_jabatan']?>" name="kode_jabatan" required class="form-control" placeholder="Kode Jabatan">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('genetika/jabatan')?>" class="btn btn-secondary">Kembali</a>
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