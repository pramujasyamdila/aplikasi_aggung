<!-- Main Content -->
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
                            <h4 class="text-white">List Cek Signal Pendaftar Langganan</h4>
                            <div class="card-header-action">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="table_bulanan_langganan" class="table">
                                    <thead class="text-center">
                                        <tr class="bg-primary">
                                            <th class="text-white">No</th>
                                            <th class="text-white">Nama</th>
                                            <th class="text-white">Telepon</th>
                                            <th class="text-white">Email</th>
                                            <th class="text-white">Alamat</th>
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
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade" id="modal_informasi_signal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kirim Informsi Signal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="javascript:;" id="form_informasi_signal" method="post">
                        <input type="hidden" name="id_user">
                        <div class="form-group">
                          <label for=""></label>
                          <textarea name="informasi_signal" class="form-control" id="" cols="30" rows="10"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button onclick="kirim_iformasi_signal()" type="button" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>