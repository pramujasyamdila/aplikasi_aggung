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
                            <h4 class="text-white">DETAIL CUSTOMER UMUM</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_user['id_user']?>" name="id_user" required class="form-control" placeholder="Nama Pegawai...">

                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="text" value="<?= $row_user['nama_user']?>" name="nama_user" required class="form-control" placeholder="Nama Pegawai...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Telepon</label>
                                            <input type="text" value="<?= $row_user['telepone']?>" name="telepone" required class="form-control" placeholder="Ex: 089782010...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Email</label>
                                            <input type="text" value="<?= $row_user['email']?>" name="email" required class="form-control" placeholder="Ex: gain@gmail.com...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Alamat</label>
                                            <textarea type="text" name="alamat" required class="form-control" placeholder="Ex: Rawakalong..."><?= $row_user['alamat']?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select value="<?= $row_user['status']?>" name="status" class="form-control" id="">
                                                <option value="1">Active</option>
                                                <option value="2">Non Active</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Foto</label>
                                            <center>
                                                <br>
                                                <img style="width: 200px;" class="image_view" src="<?= base_url('foto_user/').$row_user['file'] ?>" alt="your image" />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('customer/umum')?>" class="btn btn-secondary">Kembali</a>
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