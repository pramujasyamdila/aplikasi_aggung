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
                            <h4 class="text-white">EDIT IKLAN</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <input type="hidden" value="<?= $row_iklan['id_iklan'] ?>" name="id_iklan" required class="form-control" placeholder="Nama Pegawai...">
                                    <div class="container-fluid">
                                        <div class="form-group">
                                            <label for="">Nama</label>
                                            <input type="text" value="<?= $row_iklan['nama_iklan'] ?>" name="nama_iklan" required class="form-control" placeholder="Nama Iklan...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Deskripsi</label>
                                            <textarea type="text" name="deskripsi_iklan" required class="form-control" placeholder="Ex: Rawakalong..."><?= $row_iklan['deskripsi_iklan'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Type Voucher</label>
                                            <select name="id_voucher" class="form-control" id="">
                                                <option value="<?= $row_iklan['id_voucher'] ?>"><?= $row_iklan['nama_voucher'] ?> - <?= $row_iklan['jenis_voucher'] ?></option>
                                                <?php foreach ($result_voucher as $key => $value) { ?>
                                                    <option value="<?= $value['id_voucher'] ?>"><?= $value['nama_voucher'] ?> - <?= $value['jenis_voucher'] ?></option>
                                                <?php  } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select value="<?= $row_iklan['status_iklan'] ?>" name="status_iklan" class="form-control" id="">
                                                <option value="1">Active</option>
                                                <option value="2">Non Active</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Foto Iklan</label>
                                            <input type="file" onchange="readURL(this)" name="foto_iklan" class="form-control" placeholder="" aria-describedby="helpId">
                                            <center>
                                                <br>
                                                <img style="width: 200px;" class="image_view" src="<?= base_url('foto_iklan/') . $row_iklan['foto_iklan'] ?>" alt="your image" />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('customer/iklan') ?>" class="btn btn-secondary">Kembali</a>
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