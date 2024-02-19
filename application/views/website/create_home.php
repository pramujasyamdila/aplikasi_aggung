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
        <?php echo validation_errors(); ?>

        <div class="section-body">
            <!-- <h2 class="section-title">Advanced Forms</h2>
            <p class="section-lead">We provide advanced input fields, such as date picker, color picker, and so on.</p> -->


            <div class="card">
                <div class="card-header">
                    <!-- <h4>Horizontal Form</h4> -->
                </div>
                <form action="<?= base_url('website/store'); ?>" method="post" enctype="multipart/form-data">

                    <div class="card-body">
                        <!-- form 3 -->
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="inputCity">Judul</label>
                                <input type="text" name="judul" class="form-control" id="inputCity" value="<?php echo set_value('judul'); ?>">
                            </div>
                            <div class="form-group col-md-5">
                                <label for="inputZip">Sub Judul</label>
                                <input type="text" name="sub_judul" class="form-control" id="inputZip" value="<?php echo set_value('sub_judul'); ?>">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputState">Status</label>
                                <select id="inputState" name="status" class="form-control">
                                    <option value="">Choose...</option>
                                    <option value="1" <?php echo set_select('status', '1'); ?>>Aktif</option>
                                    <option value="2" <?php echo set_select('status', '2'); ?>>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- form bawah -->

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputCity">Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" id="inputCity">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="inputZip">Deskripsi</label>
                                <textarea type="text" name="deskripsi" id="editor" placeholder="Isu Pembahasan" class="form-control" required><?php echo set_value('deskripsi'); ?></textarea>

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