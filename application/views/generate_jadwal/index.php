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
                            <h4 class="text-white">Generate Meeting</h4>
                            <div class="card-header-action">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal_tambah" class="btn btn-success">
                                    <i class="fas fa fa-plus"></i> Generate Jadwal Meeting
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="table" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Kode meeting</th>
                                            <th class="text-white">Nama meeting</th>
                                            <th class="text-white">Jabatan</th>
                                            <th class="text-white">Divisi</th>
                                            <th class="text-white">Waktu</th>
                                            <th class="text-white">Hari</th>
                                            <th class="text-white">Tanggal</th>
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
    <div class="modal-dialog">
        <form action="javascript:;" id="form_tambah" method="post">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Kode meeting</label>
                            <input type="text" name="kode_meeting" required class="form-control" placeholder="Masukan Kode meeting">
                        </div>
                        <div class="form-group">
                            <label for="">Nama meeting</label>
                            <input type="text" name="nama_meeting" required class="form-control" placeholder="Nama meeting...">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Jabatan</label>
                            <select name="id_jabatan" class="form-control" id="">
                                <option value="">--Pilih Nama Jabatan--</option>
                                <?php foreach ($jabatan as $key => $value) { ?>
                                    <option value="<?= $value['id_jabatan']?>"><?= $value['nama_jabatan']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Divisi</label>
                            <select name="id_divisi" class="form-control" id="">
                                <option value="">--Pilih Nama Divisi--</option>
                                <?php foreach ($divisi as $key => $value) { ?>
                                    <option value="<?= $value['id_divisi']?>"><?= $value['nama_divisi']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Waktu</label>
                            <select name="id_waktu" class="form-control" id="">
                                <option value="">--Pilih Nama Waktu--</option>
                                <?php foreach ($waktu as $key => $value) { ?>
                                    <option value="<?= $value['id_waktu']?>"><?= $value['nama_waktu']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Hari</label>
                            <select name="id_hari" class="form-control" id="">
                                <option value="">--Pilih Nama Hari--</option>
                                <?php foreach ($hari as $key => $value) { ?>
                                    <option value="<?= $value['id_hari']?>"><?= $value['nama_hari']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="datetime-local" name="tanggal" required class="form-control" placeholder="Tanggal...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                </div>
        </form>
    </div>
</div>
</div>