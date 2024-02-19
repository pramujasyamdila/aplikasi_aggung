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
                <form action="<?= base_url('website/update_about_text/' . $about_text->id_about_text); ?>" method="post" enctype="multipart/form-data">

                    <div class="card-body">
                        <!-- form 3 -->
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="inputCity">Judul</label>
                                <input type="text" name="judul" class="form-control" id="inputCity" value="<?= $about_text->judul; ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputZip">Sub Judul</label>
                                <input type="text" name="sub_judul" class="form-control" id="inputZip" value="<?= $about_text->sub_judul; ?>">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputZip">Deskripsi</label>
                                <textarea type="text" name="deskripsi" id="editor" placeholder="Isu Pembahasan" class="form-control" required><?= $about_text->deskripsi; ?></textarea>
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