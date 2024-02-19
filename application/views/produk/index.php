<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>PRODUK</h1>
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
                            <h4 class="text-white">DATA PRODUK</h4>
                            <div class="card-header-action">
                                <a href="javascript:;" data-toggle="modal" data-target="#modal_tambah" class="btn btn-success">
                                    <i class="fas fa fa-plus"></i> Tambah
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="table" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Foto Produk</th>
                                            <th class="text-white">Nama Produk</th>
                                            <th class="text-white">Harga Produk</th>
                                            <th class="text-white">Jenis Produk</th>
                                            <th class="text-white">Keterangan Produk</th>
                                            <th class="text-white">Jumlah Produk</th>
                                            <th class="text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
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
<div class="modal fade" id="modal_tambah" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog">
        <form action="javascript:;" id="form_tambah" method="post">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="">Nama produk</label>
                            <input type="text" name="nama_produk" required class="form-control" placeholder="Nama produk...">
                        </div>
                        <div class="form-group">
                            <label for="">Harga produk </label>
                            <input type="number" name="harga_produk" required class="form-control" placeholder="Ex: Harga produk...">
                        </div>
                        <div class="form-group">
                            <label for="">Jenis produk </label>
                            <input type="text" name="jenis_produk" required class="form-control" placeholder="Ex: Jenis produk...">
                        </div>
                        <!-- <div class="form-group">
                            <label for="">Harga Batas Penawaran produk ( Reseller ) </label>
                            <input type="number" name="harga_batas_penawaran_reseler" required class="form-control" placeholder="Ex: Harga Batas Penawaran produk...">
                        </div> -->
                        <div class="form-group">
                            <label for="">Jumlah produk</label>
                            <input type="number" name="qty_produk" required class="form-control" placeholder="Ex: Jumlah produk...">
                        </div>
                        <div class="form-group">
                            <label for="">Keterangan produk</label>
                            <textarea class="form-control" name="ket_produk" id="" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Foto produk</label>
                            <input type="file" onchange="readURL(this)" name="foto_produk" accept="image/*" class="form-control" placeholder="" aria-describedby="helpId">
                            <center>
                                <br>
                                <img style="width: 200px;" class="image_view" src="<?= base_url('assets/image/vire.jpg') ?>" alt="your image" />
                            </center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                </div>
        </form>
    </div>
</div>
</div>
<div class="modal fade" id="modal_tambah_gambar" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="javascript:;" id="form_tambah_gambar" method="post">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Gambar produk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <div class="form-group">
                                <input type="hidden" name="id_produk">
                                <label for="">Foto produk</label>
                                <input type="file" onchange="readURL(this)" name="foto_detail_produk" accept="image/*" class="form-control" placeholder="" aria-describedby="helpId">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                </div>
                                <center>
                                    <br>
                                    <img style="width: 200px;" class="image_view" src="<?= base_url('assets/image/vire.jpg') ?>" alt="your image" />
                                </center>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                Detail Gambar
                            </div>
                            <div class="card-body">
                                <table id="table_gambar" class="table table-bordered">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Foto produk</th>
                                            <th class="text-white">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>