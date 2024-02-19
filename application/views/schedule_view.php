<!-- application/views/schedule_view.php -->


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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Divisi</th>
                                            <th>Jabatan</th>
                                            <th>Nama Meeting</th>
                                            <th>Waktu</th>
                                            <th>Hari</th>
                                            <th>Room</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1;
                                        foreach ($optimized_schedule as $schedule) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?php echo $schedule['nama_divisi']; ?></td>
                                                <td><?php echo $schedule['nama_jabatan']; ?></td>
                                                <td><?php echo $schedule['nama_meeting']; ?></td>
                                                <td><?php echo $schedule['tanggal']; ?></td>
                                                <td><?php echo $schedule['nama_hari']; ?></td>
                                                <td><?php echo $schedule['room']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
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
</div>