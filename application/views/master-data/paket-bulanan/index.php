<!-- Main Content -->
<div class="main-content">
  <section class="section">

    <div class="alert alert-warning alert-dismissible show fade">
      <div class="alert-body">
        <button class="close" data-dismiss="alert">
          <span>&times;</span>
        </button>
        <?= $title ?>
      </div>
    </div>
    <!-- tabel -->

    <div class="col-md-3 my-3">
      <label for="" class="label-control"></label>
      <div class="form-group">

        <a href="#" data-toggle="modal" data-target="#exampleModalCenter" type="submit" class="btn btn-success"><i class="fa fa-plus-square"></i> Tambah</a>
      </div>
    </div>
    <div class="col-12">
      <div class="card">
        <!-- <div class="card-header">
					<h4>Basic DataTables</h4>
				</div> -->
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-1">
              <thead>
                <tr>
                  <th>NO</th>
                  <th>Nama Paket</th>
                  <th>Harga</th>
                  <th>Aksi</th>

                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($paket_bulanan as $paket) { ?>
                  <tr>

                    <td><?= $no++ ?></td>
                    <td><?= $paket->nama_paket_bulanan; ?></td>
                    <td><?= $paket->harga_paket_bulanan; ?></td>
                    <td>
                      <a href="<?= base_url('master_data/ubah/' . $paket->id_paket_bulanan_pilihan); ?>" class="btn btn-info"><i class="fas fa-edit"></i> Edit</a>
                      <a href="<?= base_url('master_data/hapus/' . $paket->id_paket_bulanan_pilihan); ?>" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

</section>
<!-- start modal -->
<!-- end batas modal -->

</div>

<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('master_data/simpan'); ?>" method="post">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama Paket</label>
            <input type="text" class="form-control" id="recipient-name" name="nama_paket_bulanan" required>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Harga</label>
            <input type="number" class="form-control" id="recipient-name" name="harga_paket_bulanan" required>
          </div>
          <button type="submit" type="submit" value="Simpan" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>