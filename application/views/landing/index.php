<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title> HOME</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/') ?>logo-getlink.png" type="image/png">

    <!-- General CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


    <!-- CSS Libraries -->
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/datatable/datatables.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/datatable/select.bootstrap4.min.css">


    <!-- Template CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/components.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= base_url('assets/'); ?>sweetalert2/sweetalert2.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/'); ?>js/sweetalert.min.js"></script>
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg" style="height: 70px;"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="index.html" class="navbar-brand sidebar-gone-hide">Aplikasi SPK Saw & AHP Penerimaan Pekerjaan</a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Kirim Data Lamaran Anda</h1>
                    </div>
                    <?php if ($this->session->flashdata('pesan')) {
                        echo '  <div class="alert alert-success alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h5> Berhasil !</h5>';
                        echo  $this->session->flashdata('pesan');
                        echo ' Silakan Menunggu Kami Informasikan Jika Anda Lolos Melalui Nomor Telepon Yang Telah Anda Daftarkan</div>';
                    } ?>
                    <div class="section-body">
                        <form action="<?= base_url('spk/kirim_lamaran_saya') ?>" enctype="multipart/form-data" method="post">
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
                                                <input type="text" required name="nama_lengkap" class="form-control" placeholder="Masukan Nama Lengkap...">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nomor Telepon</label>
                                                <input type="text" required name="nomor_telepon" placeholder="Ex: 0897xxxxx" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="text" required name="email" placeholder="Masukan Alamat Email..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Kewarganegaraan</label>
                                                <select name="kewarganegaraan" class="form-control">
                                                    <option value="">-- Pilih Kewarganegaraan ---</option>
                                                    <option value="WNI">WNI</option>
                                                    <option value="WNA">WNA</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Alamat Lengkap</label>
                                                <textarea name="alamat_lengkap" class="form-control" style="height: 100px;"></textarea>
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
                                                <select name="tingkat_pendidikan" class="form-control">
                                                    <option value="">-- Pilih Tingkat Pendidikan Terakhir ---</option>
                                                    <option value="SMA">SMA</option>
                                                    <option value="DIPLOMA">DIPLOMA</option>
                                                    <option value="SARJANA">SARJANA</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nama Institusi Pendidikan</label>
                                                <input type="text" required name="nama_institusi_pendidikan" placeholder="Ex: UNIVERSITAS ESA UNGGUL" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Nama Gelar</label>
                                                <input type="text" required name="nama_gelar" placeholder="Masukan Nama Gelar..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tahun Lulus</label>
                                                <input type="text" required name="tahun_lulus" placeholder="Tahun Lulus Ex: 2024..." class="form-control">
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
                                                <input type="text" required name="nama_institusi_pekerjaan" placeholder="Ex: PT. PRIVOT" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Jabatan</label>
                                                <input type="text" required name="nama_jabatan" placeholder="Masukan Nama Jabatan..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Lama Bekerja</label>
                                                <input type="text" required name="lama_bekerja" placeholder="Tahun Lulus Ex: 3 Tahun..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Tanggung Jawab Utama Dan Penghasilan Yang Dicapai</label>
                                                <input type="text" required name="tanggung_jawab" placeholder="Tahun Lulus Ex: 3 Tahun..." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Masukan Pengalaman Kerja Lain Jika Ada</label>
                                                <textarea name="pengalaman_kerja_lainya" class="form-control" style="height: 100px;"> Ex : PT PERTAMINA , PT JASAMARGA</textarea>
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
                                                <textarea name="keterampilan" class="form-control" style="height: 100px;"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Bahasa Yang Anda Kuasai</label>
                                                <textarea name="bahasa_keterampilan" class="form-control" style="height: 100px;"></textarea>
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
                                                <label for="">File</label>
                                                <input type="file" required class="form-control" name="file">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success"> KIRIM LAMARAN </button>
                        </form>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>
    </div>
    </div>

    <!-- ckeditor -->
    <script src="<?php echo base_url(); ?>assets/plugins/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/stisla.js"></script>

    <!-- JS Libraies -->
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/datatable/datatables.min.js"></script>
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/datatable/dataTables.select.min.js"></script>
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/datatable/jquery-ui.min.js"></script>
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/datatable/modules-datatables.js"></script>



    <!-- Template JS File -->
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/scripts.js"></script>
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/custom.js"></script>
    <!-- JS Libraies -->
    <script src="<?= base_url('assets/stisla_master') ?>/node_modules/chart.js/dist/Chart.min.js"></script>
    <!-- Page Specific JS File -->
    <script src="<?= base_url('assets/stisla_master') ?>/assets/js/page/modules-chartjs.js"></script>
    <!-- Page Specific JS File -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- dataTables -->

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
</body>

</html>