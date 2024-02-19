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
                            <h4 class="text-white">DATA DETAIL PELAMAR</h4>
                        </div>
                        <div class="card-body">
                            <!-- informasi Peribadi -->
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Informasi Pribadi</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="">Nama Lengkap</label>
                                                <input type="text" value="<?= $row_lamaran['nama_lengkap'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nomor Telepon</label>
                                                <input type="text" required value="<?= $row_lamaran['nomor_telepon'] ?>" name="nomor_telepon" placeholder="Ex: 0897xxxxx" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" required value="<?= $row_lamaran['email'] ?>" name="email" placeholder="Masukan Alamat Email..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Kewarganegaraan</label>
                                                <select name="kewarganegaraan" class="form-control">
                                                    <option value="<?= $row_lamaran['nomor_telepon'] ?>"><?= $row_lamaran['nomor_telepon'] ?></option>
                                                    <option value="WNI">WNI</option>
                                                    <option value="WNA">WNA</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Alamat Lengkap</label>
                                                <textarea name="alamat_lengkap" class="form-control" style="height: 100px;"><?= $row_lamaran['alamat_lengkap'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Riwayat Pendidikan -->
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Riwayat Pendidikan</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="">Tingkat Pendidikan Terakhir</label>
                                                <input type="text" value="<?= $row_lamaran['tingkat_pendidikan'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nama Institusi Pendidikan</label>
                                                <input type="text" value="<?= $row_lamaran['nama_institusi_pendidikan'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nama Gelar</label>
                                                <input type="text" value="<?= $row_lamaran['nama_gelar'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tahun Lulus</label>
                                                <input type="text" value="<?= $row_lamaran['tahun_lulus'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Riwayat Pekerjaan Sebelumnya Terutama Yang Relevan Dengan Posisi Yang Anda Lamar.</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="">Nama Institusi Pekerjaan</label>
                                                <input type="text" value="<?= $row_lamaran['nama_institusi_pekerjaan'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Jabatan</label>
                                                <input type="text" value="<?= $row_lamaran['nama_jabatan'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Lama Bekerja</label>
                                                <input type="text" value="<?= $row_lamaran['lama_bekerja'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tanggung Jawab Utama Dan Penghasilan Yang Dicapai</label>
                                                <input type="text" value="<?= $row_lamaran['tanggung_jawab'] ?>" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Masukan Pengalaman Kerja Lain Jika Ada</label>
                                                <textarea name="pengalaman_kerja_lainya" class="form-control" style="height: 100px;"> <?= $row_lamaran['pengalaman_kerja_lainya'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Keterampilan Dan Kemampuan.</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="">Jabarkan Keterampilan Anda Disini</label>
                                                <textarea name="keterampilan" class="form-control" style="height: 100px;"><?= $row_lamaran['keterampilan'] ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Bahasa Yang Anda Kuasai</label>
                                                <textarea name="bahasa_keterampilan" class="form-control" style="height: 100px;"><?= $row_lamaran['bahasa_keterampilan'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4>Lampiran CV/IJASAH Jadikan Satu File.</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <a class="btn btn-warning" href="<?= base_url('file_cv/' . $row_lamaran['file']) ?>"> <i class="fas fa fa-file"></i> <?= $row_lamaran['file'] ?></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="<?= base_url('spk/data_pelamar') ?>" class="btn btn-secondary">Kembali</a>
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
</div>