<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <!-- <div class="section-header">
            <h1>Dashboard</h1>
          </div> -->
    <h4 style="color:white;"><?= $title ?></h4>
    <br>
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-primary">
            <i class="far fa-file"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Sudah Bayar</h4>
            </div>
            <div class="card-body">
              <?= $sudah_bayar ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-danger">
            <i class="far fa-calendar"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Belum Bayar</h4>
            </div>
            <div class="card-body">
              <?= $belum_bayar ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-warning">
            <i class="far fa-plus-square"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Pendapatan Masuk</h4>
            </div>
            <div class="card-body">
              <?php
              $total_masuk = 0;
              foreach ($riwayat_pemabayaran as $key => $value) { ?>
                <?php $total_masuk += $value['total_pesanan'] ?>
              <?php } ?>

              <?= "Rp " . number_format($total_masuk, 2, ',', '.') ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-success">
            <i class="fas fa-users"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>Rp. Belum Dibayar</h4>
            </div>
            <div class="card-body">
              <?php
              $total_keluar = 0;
              foreach ($riwayat_pemabayaran_belum as $key => $value) { ?>
                <?php $total_keluar += $value['total_pesanan'] ?>
              <?php } ?>

              <?= "Rp " . number_format($total_keluar, 2, ',', '.') ?>

            </div>
          </div>
        </div>
      </div>
    </div>


    <form action="<?= base_url('pembayaran/mitra') ?>" method="post">
      <div class="row">
        <div class="col-md-3">
          <div class="form-group">
            <label for="" class="label-control" style="color:blue; font-size:15px">Date From</label>
            <input type="date" name="tanggal_bayar_awal" value="" class="form-control" id="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="" class="label-control" style="color:blue; font-size:15px">Date To</label>
            <input type="date" name="tanggal_bayar_akhir" value="" class="form-control" id="">
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="" class="label-control" style="color:blue; font-size:15px">Status Bayar</label>
            <select class="form-control" name="status_bayar">
              <option selected value="">ALL</option>
              <option value="PENDING">PENDING</option>
              <option value="PAID">PAID</option>
              <option value="EXPIRED">EXPIRED</option>
            </select>
          </div>
        </div>
        <div class="col-md-3 my-3">
          <label for="" class="label-control"></label>
          <div class="form-group">
            <button type="submit" class="btn btn-dark btn-sm"><i class="fa fa-filter"></i> Filter</button>
          </div>
        </div>
    </form>
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
					<h4>Basic DataTables</h4>
				</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Nama User</th>
                  <th>Ket Pembayaran</th>
                  <th>Tanggal Expired</th>
                  <th>Tanggal Bayar</th>
                  <th>Nominal Bayar</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php $nomor = 1;
                foreach ($result_riwayat as $key => $value) { ?>
                  <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= $value['nama_user'] ?></td>
                    <td><?= $value['keterangan'] ?></td>
                    <?php if ($value['tanggal_bayar'] == NULL) { ?>
                      <td><?= $value['expired'] ?></td>
                    <?php   } else { ?>
                      <td>-</td>
                    <?php   }
                    ?>
                    <?php if ($value['tanggal_bayar'] == NULL) { ?>
                      <td><?= $value['expired'] ?></td>
                    <?php   } else { ?>
                      <td><?= $value['tanggal_bayar'] ?></td>
                    <?php   }
                    ?>

                    <td><?= "Rp " . number_format($value['total_pesanan'], 2, ',', '.') ?></td>
                    <?php if ($value['sts_pembayaran'] == 'PAID') { ?>
                      <td>
                        <div class="badge badge-success">PAID</div>
                      </td>
                    <?php  } else if ($value['sts_pembayaran'] == 'PENDING') { ?>
                      <td>
                        <div class="badge badge-warning">PENDING</div>
                      </td>
                    <?php   } else { ?>
                      <td>
                        <div class="badge badge-danger">EXPIRED</div>
                      </td>
                    <?php   }
                    ?>
                  </tr>
                <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="4">Income Pembayaran Masuk</td>
                  <td></td>
                  <td> <?= "Rp " . number_format($total_masuk, 2, ',', '.') ?></td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="4">Belum Melakukan Pembayaran</td>
                  <td></td>
                  <td> <?= "Rp " . number_format($total_keluar, 2, ',', '.') ?></td>
                  <td></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>