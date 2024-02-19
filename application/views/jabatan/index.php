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
                            <h4 class="text-white">Data Jabatan</h4>
                            <div class="card-header-action">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal_tambah" class="btn btn-success">
                                    <i class="fas fa fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="table" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Kode Jabatan</th>
                                            <th class="text-white">Nama Jabatan</th>
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
                    <h5 class="modal-title">Tambah Jabatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Kode Jabatan</label>
                            <input type="text" name="kode_jabatan" required class="form-control" placeholder="Masukan Kode Jabatan">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Jabatan</label>
                            <input type="text" name="nama_jabatan" required class="form-control" placeholder="Nama Jabatan...">
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