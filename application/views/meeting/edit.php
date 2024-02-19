<!-- Main Content -->
<!-- meeting -->
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
                            <h4 class="text-white">EDIT meeting</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <input type="hidden" name="id_meeting" value="<?= $row_meeting['id_meeting'] ?>" class="form-control" placeholder="Masukan Kode meeting">

                                    <div class="container-fluid">
                                        <div class="form-group">
                                            <label for="">Kode meeting</label>
                                            <input type="text" name="kode_meeting" value="<?= $row_meeting['kode_meeting'] ?>" required class="form-control" placeholder="Masukan Kode meeting">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama meeting</label>
                                            <input type="text" value="<?= $row_meeting['nama_meeting'] ?>" name="nama_meeting" required class="form-control" placeholder="Nama meeting...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Jabatan</label>
                                            <select name="id_jabatan" class="form-control" id="">
                                                <option value="<?= $row_meeting['id_jabatan'] ?>"><?= $row_meeting['nama_jabatan'] ?></option>
                                                <?php foreach ($jabatan as $key => $value) { ?>
                                                    <option value="<?= $value['id_jabatan'] ?>"><?= $value['nama_jabatan'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nama Divisi</label>
                                            <select name="id_divisi" class="form-control" id="">
                                                <option value="<?= $row_meeting['id_divisi'] ?>"><?= $row_meeting['nama_divisi'] ?></option>
                                                <?php foreach ($divisi as $key => $value) { ?>
                                                    <option value="<?= $value['id_divisi'] ?>"><?= $value['nama_divisi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Waktu</label>
                                            <select name="id_waktu" class="form-control" id="">
                                                <option value="<?= $row_meeting['id_waktu'] ?>"><?= $row_meeting['nama_waktu'] ?></option>
                                                <?php foreach ($waktu as $key => $value) { ?>
                                                    <option value="<?= $value['id_waktu'] ?>"><?= $value['nama_waktu'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Hari</label>
                                            <select name="id_hari" class="form-control" id="">
                                                <option value="<?= $row_meeting['id_hari'] ?>"><?= $row_meeting['nama_hari'] ?></option>
                                                <?php foreach ($hari as $key => $value) { ?>
                                                    <option value="<?= $value['id_hari'] ?>"><?= $value['nama_hari'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Tanggal</label>
                                            <input type="date" value="<?= $row_meeting['tanggal'] ?>" name="tanggal" required class="form-control" placeholder="Tanggal...">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('genetika/meeting') ?>" class="btn btn-secondary">Kembali</a>
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