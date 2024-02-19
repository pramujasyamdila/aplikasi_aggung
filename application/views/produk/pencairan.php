<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>MONITORING PENCAIRAN</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('pesan')) {
                        echo '  <div class="alert alert-success alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h5><i class="icon fas fa-exclamation-triangle"></i> Berhasil !</h5>';
                        echo  $this->session->flashdata('pesan');
                        echo ' </div>';
                    } ?>
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="text-white">MONITORING PENCAIRAN</h4>
                            <div class="card-header-action">

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table table-bordered">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">No Order</th>
                                            <th class="text-white">Nama Reseller</th>
                                            <th class="text-white">Status Pencairan</th>
                                            <th class="text-white">Metode Pembayaran</th>
                                            <th class="text-white">Total Fee Reseller</th>
                                            <th class="text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php $no = 1;
                                        foreach ($pembayaran as $key => $value) { ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $value['no_order'] ?></td>
                                                <td><label for=""><?= $value['nama_user']?></label></td>
                                                <?php if ($value['sts_pencairan'] == 1) { ?>
                                                    <td><label for="" class="badge badge-success">Sudah Di Cairkan</label></td>
                                                <?php } else { ?>
                                                    <td><label for="" class="badge badge-danger">Belum Di Cairkan</label></td>
                                                <?php }
                                                ?>
                                                 <td><label for="" class="badge badge-primary"><?= $value['metode_pembayaran'] ?></label></td>
                                                <td><?= "Rp " . number_format($value['fee_reseller'], 2, ',', '.') ?></td>
                                                <td>
                                                    <?php if ($value['sts_pencairan'] == '1') { ?>
                                                        <a href="<?= base_url('master/pembayaran_cod2/' . $value['no_order']) ?>" class="btn btn-sm btn-primary"> Lihat Bukti</a>
                                                    <?php } else { ?>
                                                        <a href="<?= base_url('master/pencairan_ke_bank/' . $value['id_transaksi']) ?>" class="btn btn-sm btn-success"> cairkan</a>
                                                        <a href="<?= base_url('master/pembayaran_cod2/' . $value['no_order']) ?>" class="btn btn-sm btn-primary"> Lihat Bukti</a>
                                                    <?php }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php   } ?>
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