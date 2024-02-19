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
                            <h4 class="text-white">Berikan Penialain Untuk</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                    <input type="hidden" value="<?= $row_lamaran['id_lamaran']?>" name="id_lamaran" required class="form-control" placeholder="Nama Hotel...">
                                        <div class="form-group">
                                            <label for="">Nama Lengkap</label>
                                            <input type="text" value="<?= $row_lamaran['nama_lengkap']?>" name="nama_lengkap" required class="form-control" placeholder="Nama Hotel...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nilai Education</label>
                                            <input type="number" value="<?= $row_lamaran['education']?>" name="education" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nilai Experience</label>
                                            <input type="number" value="<?= $row_lamaran['experience']?>" name="experience" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Nilai Skill/Kompetensi</label>
                                            <input type="number" value="<?= $row_lamaran['skills']?>" name="skills" required class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('spk/data_pelamar')?>" class="btn btn-secondary">Kembali</a>
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