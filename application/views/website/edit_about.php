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
                <form action="<?= base_url('website/update_about/' . $about->id_about); ?>" method="post" enctype="multipart/form-data">

                    <div class="card-body">
                        <!-- form 3 -->
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputState">Status</label>
                                <select id="inputState" name="status" class="form-control">
                                    <option value="">Choose...</option>
                                    <option value="1" <?php if ($about->status === '1') echo 'selected'; ?>>Aktif</option>
                                    <option value="2" <?php if ($about->status === '2') echo 'selected'; ?>>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- form bawah -->

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" required>
                                <hr>
                                <img width="320" src="<?= base_url() ?>assets/about/<?= $about->gambar ?>" alt="">
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