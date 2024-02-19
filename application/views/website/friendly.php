  <!-- Main Content -->

  <div class="main-content">
      <section class="section">

          <div class="alert alert-warning alert-dismissible show fade">
              <div class="alert-body">
                  <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                  </button>
                  Informasi : Halaman ini menampilkan data untuk kelola tampilan landing page - Friendly
              </div>
          </div>

          <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header">
                          <!-- <a href="<?= base_url('website/create_friendly'); ?>" class="btn btn-info"> Add</a> -->
                      </div>
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="table table-striped" id="table-1">
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
                                          <?php foreach ($friendly as $fr) : ?>

                                              <td><?= $fr->judul; ?></td>
                                              <td>
                                                  <?= $fr->sub_judul; ?>
                                              </td>
                                              <td> <?= $fr->deskripsi; ?></td>
                                            
                                              <td>
                                                  <a onclick="return confirm('Ubah Data?')" href="<?= base_url('website/edit_friendly/' . $fr->id_friendly); ?>" class="btn btn-primary"><i class="fa fa-edit"></i></a>

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
                      <div class="card-header">
                          <a href="<?= base_url('website/create_friendly_image'); ?>" class="btn btn-info"> Add</a>
                      </div>
                          <div class="table-responsive">
                              <table class="table">
                                  <thead>
                                      <tr>
                                          <th>Gambar</th>
                                          <th>Status</th>
                                          <th>Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <tr>
                                          <?php foreach ($friendly_image as $fi) : ?>

                                              <td>
                                              <a href="" data-toggle="modal" data-target="#imageModal">
                                                      <img alt="image" src="<?= base_url() ?>assets/create_friendly_image/<?= $fi->gambar ?>" class="square-circle" width="100px" data-toggle="tooltip" title="Image">
                                                  </a>
                                              </td>
                                              <td>
                                              <div>

                                            <?php
                                            switch ($fi->status) {
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
                                              <a onclick="return confirm('Apakah anda yakin ingin dihapus?')" href="<?= base_url('website/delete_friendly_image/' . $fi->id_friendly_image); ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

