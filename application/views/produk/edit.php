<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>EDIT PRODUK</h1>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="text-white">EDIT PRODUK</h4>
                        </div>
                        <div class="card-body">
                            <form action="javascript:;" id="form_edit" method="post">
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <input type="hidden" value="<?= $row_produk['id_produk'] ?>" name="id_produk" required class="form-control" placeholder="Nama produk...">
                                        <div class="form-group">
                                            <label for="">Nama produk</label>
                                            <input type="text" value="<?= $row_produk['nama_produk'] ?>" name="nama_produk" required class="form-control" placeholder="Nama produk...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Jenis produk</label>
                                            <input type="text" value="<?= $row_produk['jenis_produk'] ?>" name="jenis_produk" required class="form-control" placeholder="Jenis produk...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Harga produk </label>
                                            <input type="text" name="harga_produk" value="<?= $row_produk['harga_produk'] ?>" required class="form-control" placeholder="Ex: Harga produk...">
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="">Harga Batas Penawaran produk ( Reseller ) </label>
                                            <input type="text" name="harga_batas_penawaran_reseler" value="<?= $row_produk['harga_batas_penawaran_reseler'] ?>" required class="form-control" placeholder="Ex: Harga Batas Penawaran ...">
                                        </div> -->
                                        <div class="form-group">
                                            <label for="">Qty produk </label>
                                            <input type="text" name="qty_produk" value="<?= $row_produk['qty_produk'] ?>" required class="form-control" placeholder="Ex: Qty produk...">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Keterangan produk </label>
                                        <textarea name="ket_produk" class="form-control" id="" cols="30" rows="10"><?= $row_produk['ket_produk'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Foto Produk</label>
                                            <input type="file" onchange="readURL(this)" name="foto_produk" class="form-control" placeholder="" aria-describedby="helpId">
                                            <center>
                                                <br>
                                                <img style="width: 200px;" class="image_view" src="<?= base_url('foto_produk/') . $row_produk['foto_produk'] ?>" alt="your image" />
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary button_simpan">Save</button>
                                    <a href="<?= base_url('master/produk') ?>" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
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