<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>MY &mdash; Getlink</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url('assets/stisla_master') ?>/assets/css/components.css">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="d-flex flex-wrap align-items-stretch">
        <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
          <div class="p-4 m-3">
            <h2 class="text-dark font-weight-normal">
            <?php if ($this->session->flashdata('notif')) {
            echo $this->session->flashdata('notif');
        } ?>
            <img src="<?= base_url('assets/') ?>logo-getlink.png" alt="logo" width="70" class="shadow-light rounded-circle mb-4 mt-4">
         <u class="font-weight-bold">LOGIN</u></h2>
            <!-- <form method="POST" action="<?= base_url('auth')?>" class="needs-validation" novalidate=""> -->
            <form method="POST" action="<?= base_url('auth') ?>">
            <div class="form-group">
        <label for="username">Username</label>
        <input id="username" type="text" class="form-control" name="username" tabindex="1" required autofocus>
        <div class="invalid-feedback">
            <?= form_error('username') ?>
        </div>
    </div>

    <div class="form-group">
        <div class="d-block">
            <label for="password" class="control-label">Password</label>
            <div class="input-group">
                <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                <div class="input-group-append">
                    <span class="input-group-text" id="togglePassword" onclick="togglePassword()">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
            <div class="invalid-feedback">
                <?= form_error('password') ?>
            </div>
        </div>
    </div>
              <div class="form-group lg-md-12">
                <?php echo $widget; ?>
                <?php echo $script; ?>
            </div>
              <div class="form-group text-left">
                <!-- <a href="" class="btn btn-primary btn-lg mt-3">
                Login
                </a> -->
                <button type="submit" class="btn btn-dark rounded"><span class="fas fa-sign-in-alt"> Login</span></button>
                <button type="button" class="btn btn-warning rounded" onclick="clearForm()"><span class="fas fa-eraser"> Clear</span></button>
                
                <script>
                function clearForm() {
                    document.getElementById('username').value = '';
                    document.getElementById('password').value = '';
                }

                function togglePassword() {
                    var passwordInput = document.getElementById('password');
                    var togglePasswordButton = document.getElementById('togglePassword');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        togglePasswordButton.innerHTML = '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
                    } else {
                        passwordInput.type = 'password';
                        togglePasswordButton.innerHTML = '<i class="fa fa-eye" aria-hidden="true"></i>';
                    }
                }
                </script>
                <!-- <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                  Login
                </button> -->
              </div>
              
            </form>
            <?= $this->session->flashdata('message'); ?>
            <?php if ($this->session->flashdata('pesan')) {
                echo '  <div class="alert alert-warning alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h5><i class="icon fas fa-exclamation-triangle"></i> Maaf!</h5>';
                echo  $this->session->flashdata('pesan');
                echo ' </div>';
            } ?>

            <?php if ($this->session->flashdata('salah')) {
                echo '  <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h5><i class="icon fas fa-exclamation-triangle"></i> Maaf !</h5>';
                echo  $this->session->flashdata('salah');
                echo ' </div>';
            } ?>

            <?php if ($this->session->flashdata('tidak_bisa')) {
                echo '  <div class="alert alert-danger alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h5> Maaf !</h5>';
                echo  $this->session->flashdata('tidak_bisa');
                echo ' </div>';
            } ?>

            <?php if ($this->session->flashdata('berhasil')) {
                echo '  <div class="alert alert-success alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <h5><i class="icon fas fa-exclamation-triangle"></i> Berhasil !</h5>';
                echo  $this->session->flashdata('berhasil');
                echo ' </div>';
            } ?>
            <?= form_close(); ?>
            <div class="text-center mt-5 text-small">
              &copy; Global Evolusi Teknologi &mdash; with 💙 by Stisla
              
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom" data-background="<?= base_url('assets/stisla_master') ?>/assets/img/unsplash/login-bg.jpg">
          <div class="absolute-bottom-left index-2">
            <div class="text-light p-5 pb-2">
              <div class="mb-5 pb-3">
                <h1 class="mb-2 display-4 font-weight-bold">
                                <?php
                date_default_timezone_set('Asia/Jakarta');
                $jam = date('H:i');

                if ($jam >= '03:00' && $jam < '10:00') {
                    $ucapan = "Selamat pagi";
                } elseif ($jam >= '11:00' && $jam < '15:00') {
                    $ucapan = "Selamat siang";
                } elseif ($jam >= '16:00' && $jam < '17:30') {
                    $ucapan = "Selamat sore";
                } else {
                    $ucapan = "Selamat malam";
                }
                ?>

                <h2 id="ucapan"><?php echo $ucapan; ?></h2>
                <p id="jam"></p>

                <script>
                function updateJam() {
                    var waktu = new Date();
                    var jam = waktu.getHours();
                    var menit = waktu.getMinutes();
                    var detik = waktu.getSeconds();

                    jam = jam < 10 ? '0' + jam : jam;
                    menit = menit < 10 ? '0' + menit : menit;
                    detik = detik < 10 ? '0' + detik : detik;

                    var jamString = jam + ':' + menit + ':' + detik;

                    document.getElementById('jam').innerHTML = 'Jam saat ini: ' + jamString;

                    document.getElementById('ucapan').innerHTML = jam >= 3 && jam < 10
                        ? "Selamat pagi"
                        : (jam >= 11 && jam < 15
                            ? "Selamat siang"
                            : (jam >= 16 && jam < 17 && menit < 30
                                ? "Selamat sore"
                                : "Selamat malam"));

                    setTimeout(updateJam, 1000);
                }

                updateJam();
                </script>

                </h1>
              </div>
              <!-- Photo by <a class="text-light bb" target="_blank" href="https://unsplash.com/photos/a8lTjWJJgLA">Justin Kauffman</a> on <a class="text-light bb" target="_blank" href="https://unsplash.com">Unsplash</a> -->
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="<?= base_url('assets/stisla_master') ?>/assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="<?= base_url('assets/stisla_master') ?>/assets/js/scripts.js"></script>
  <script src="<?= base_url('assets/stisla_master') ?>/assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
