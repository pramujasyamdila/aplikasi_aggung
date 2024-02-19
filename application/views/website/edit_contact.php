<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= $title ?></h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Advanced Forms</div>
            </div>
        </div>

        <div class="section-body">
            <!-- <h2 class="section-title">Advanced Forms</h2>
            <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p> -->
            <?php echo validation_errors(); ?>


            <div class="card">
                <div class="card-header">

                </div>
                <form action="<?= base_url('website/update_contact/' . $contact->id_contact); ?>" method="post" enctype="multipart/form-data">

                    <div class="card-body">
                        <!-- form 3 -->
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="inputCity">Nama Perusahaan</label>
                                <input type="text" name="perusahaan" class="form-control" id="inputCity" value="<?= $contact->perusahaan; ?>">
                            </div>
                            <div class="form-group col-md-7">
                                <label for="inputZip">Alamat</label>
                                <textarea name="alamat" class="form-control" cols="6"><?= $contact->alamat; ?></textarea>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputZip">No Telephone</label>
                                <input type="text" name="no_telp" class="form-control" id="inputZip" value="<?= $contact->no_telp; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputZip">Jam Operasional</label>
                                <input type="text" name="jam_operasional" class="form-control" id="inputZip" value="<?= $contact->jam_operasional; ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputZip">Email</label>
                                <input type="email" name="email" class="form-control" id="inputZip" value="<?= $contact->email; ?>">
                            </div>
                        </div>

                        <!-- form bawah -->

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputCity">Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" required>
                                <hr>
                                <img width="320" src="<?= base_url() ?>assets/contact/<?= $contact->gambar ?>" alt="">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- <button class="btn btn-primary">Simpan</button> -->
                        <input type="submit" class="btn btn-primary" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>