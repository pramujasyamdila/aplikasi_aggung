  <!-- Main Content -->

  <div class="main-content">
      <section class="section">

          <div class="alert alert-warning alert-dismissible show fade">
              <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                  </button>
                  Informasi : Halaman ini menampilkan data untuk kelola tampilan landing page - Product
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header">
                          <a href="<?= base_url('website/create_product'); ?>" class="btn btn-info"> Add</a>
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-striped" id="table-1">
                                  <thead>
                                      <tr>
                                          <th>Judul</th>
                                          <th>Sub Judul</th>
                                          <th>Deskripsi</th>
                                          <th>Gambar</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <?php foreach ($product as $p) : ?>

                                              <td><?= $p->judul; ?></td>
                                              <td>
                                                  <?= $p->sub_judul; ?>
                                              </td>
                                              <td> <?= $p->deskripsi; ?></td>
                                              <td>
                                                  <a href="" data-toggle="modal" data-target="#imageModal">
                                                      <img alt="image" src="<?= base_url() ?>assets/product/<?= $p->gambar ?>" class="square-circle" width="100px" data-toggle="tooltip" title="Image">
                                                  </a>

                                              </td>
                                              <td>
                                                  <div>
                                                      <?php
                                                        switch ($p->status) {
                                                            case 1:
                                                                echo '<span class="badge badge-info">Aktif</span>';
                                                                break;
                                                            default:
                                                                echo '<span class="badge badge-danger">Non Aktif</span>';
                                                                break;
                                                        }
                                                        ?>
                                                  </div>
                                              </td>
                                              <td>
                                                  <a onclick="return confirm('Ubah Data?')" href="<?= base_url('website/edit_product/' . $p->id_product); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                  <a onclick="return confirm('Apakah anda yakin ingin dihapus?')" href="<?= base_url('website/delete_product/' . $p->id_product); ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>

                                              </td>
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
  </div>

  <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="imageModalLabel">View Gambar</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <img width="80%" alt="image" src="<?= base_url() ?>assets/product/<?= $p->gambar ?>">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
          </div>
      </div>
  </div>