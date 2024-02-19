<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <!-- <div class="section-header">
            <h1><?= $title ?></h1>
        </div> -->
        <div class="alert alert-warning alert-dismissible show fade">
            <div class="alert-body">
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
                <?= $title ?>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="text-white">DATA KONTER</h4>
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
                                            <th class="text-white">Nama</th>
                                            <th class="text-white">Telepon</th>
                                            <th class="text-white">Kode Referal</th>
                                            <th class="text-white">Alamat</th>
                                            <th class="text-white">Lokasi Penjualan</th>
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
                    <h5 class="modal-title">Tambah Konter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" name="nama_user" required class="form-control" placeholder="Nama Konter...">
                        </div>
                        <div class="form-group">
                            <label for="">Telepon</label>
                            <input type="text" name="telepone" required class="form-control" placeholder="Ex: 089782010...">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" required class="form-control" placeholder="Ex: gain@gmail.com...">
                        </div>
                        <div class="form-group">
                            <label for="">Lokasi Penjualan</label>
                            <select name="id_lokasi" class="form-control" id="">
                                <?php foreach ($result_lokasi as $key => $value) { ?>
                                    <option value="<?= $value['id_lokasi'] ?>"><?= $value['nama_lokasi'] ?></option>
                                <?php   } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea type="text" name="alamat" required class="form-control" placeholder="Ex: Rawakalong..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" class="form-control" id="">
                                <option value="1">Active</option>
                                <option value="2">Non Active</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" onchange="readURL(this)" name="file" class="form-control" placeholder="" aria-describedby="helpId">
                            <center>
                                <br>
                                <img style="width: 200px;" class="image_view" src="<?= base_url('assets/image/vire.jpg') ?>" alt="your image" />
                            </center>
                        </div>
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" required class="form-control" placeholder="Ex: Pramsco...">
                        </div>
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="password" name="password" required class="form-control" placeholder="Ex: ****...">
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