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
                            <h4 class="text-white">EDIT divisi</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_divisi['id_divisi']?>" name="id_divisi" required class="form-control" placeholder="Nama divisi...">

                                        <div class="form-group">
                                            <label for="">Nama divisi</label>
                                            <input type="text" value="<?= $row_divisi['nama_divisi']?>" name="nama_divisi" required class="form-control" placeholder="Nama divisi...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Kode divisi</label>
                                            <input type="text" value="<?= $row_divisi['kode_divisi']?>" name="kode_divisi" required class="form-control" placeholder="Kode divisi">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('genetika/divisi')?>" class="btn btn-secondary">Kembali</a>
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