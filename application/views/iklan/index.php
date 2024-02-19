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
                            <h4 class="text-white">DATA IKLAN</h4>
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
                                            <th class="text-white">Nama Iklan</th>
                                            <th class="text-white">Type Voucher</th>
                                            <th class="text-white">Deskripsi</th>
                                            <th class="text-white">Foto</th>
                                            <th class="text-white">Status</th>
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
                    <h5 class="modal-title">Tambah Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama_iklan" required class="form-control" placeholder="Nama Iklan...">
                        </div>
                        <div class="form-group">
                            <label for="">Deskripsi</label>
                            <textarea type="text" name="deskripsi_iklan" required class="form-control" placeholder="Ex: Rawakalong..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="">Type Voucher</label>
                            <select name="id_voucher" class="form-control" id="">
                                <?php foreach ($result_voucher as $key => $value) { ?>
                                    <option value="<?= $value['id_voucher'] ?>"><?= $value['nama_voucher'] ?> - <?= $value['jenis_voucher'] ?></option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jenis Iklan</label>
                            <select name="jenis_iklan" class="form-control">
                                <option value="langganan">Langganan</option>
                                <option value="voucher">Voucher</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status_iklan" class="form-control" id="">
                                <option value="1">Active</option>
                                <option value="2">Non Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Foto Iklan</label>
                            <input type="file" onchange="readURL(this)" name="foto_iklan" class="form-control" placeholder="" aria-describedby="helpId">
                            <center>
                                <br>
                                <img style="width: 200px;" class="image_view" src="<?= base_url('assets/image/vire.jpg') ?>" alt="your image" />
                            </center>
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