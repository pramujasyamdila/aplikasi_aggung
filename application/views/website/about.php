  <!-- Main Content -->

  <div class="main-content">
      <section class="section">

          <div class="alert alert-warning alert-dismissible show fade">
              <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                  </button>
                  Informasi : Halaman ini menampilkan data untuk kelola tampilan landing page - ABOUT
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header">
                          <a href="<?= base_url('website/create_about'); ?>" class="btn btn-info"> Add Slider</a> &nbsp;
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table" id="table-1">
                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>Gambar</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <?php
                                            $no = 1;
                                            foreach ($about as $ab) : ?>

                                              <td>
                                                  <?= $no++ ?>
                                              </td>
                                              <td>
                                                  <a href="" data-toggle="modal" data-target="#imageModal">
                                                      <img alt="image" src="<?= base_url() ?>assets/about/<?= $ab->gambar ?>" class="square-circle" width="100px" data-toggle="tooltip" title="Image">
                                                  </a>

                                              </td>
                                              <td>
                                                  <div>

                                                      <?php
                                                        switch ($ab->status) {
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
                                                  <a onclick="return confirm('Ubah Data?')" href="<?= base_url('website/edit_about/' . $ab->id_about); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                                  <a onclick="return confirm('Apakah anda yakin ingin dihapus?')" href="<?= base_url('website/delete_about/' . $ab->id_about); ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>

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



          <!-- deskripsi -->
          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table">
                                  <thead>
                                      <tr>
                                          <th>Judul</th>
                                          <th>Sub Judul</th>
                                          <th>Deskripsi</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <?php foreach ($text as $at) : ?>

                                              <td><?= $at->judul; ?></td>
                                              <td>
                                                  <?= $at->sub_judul; ?>
                                              </td>
                                              <td> <?= $at->deskripsi; ?></td>

                                              <td>
                                                  <a onclick="return confirm('Ubah Data?')" href="<?= base_url('website/edit_about_text/' . $at->id_about_text); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>
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
                  <img width="80%" alt="image" src="<?= base_url() ?>assets/about/<?= $ab->gambar ?>">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </div>
          </div>
      </div>
  </div>