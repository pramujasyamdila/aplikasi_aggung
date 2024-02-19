<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
    <!-- bootstrap-daterangepicker -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url('assets/asset_teamplate') ?>/build/css/custom.min.css" rel="stylesheet">
    <title>Login Page</title>
</head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Raleway, sans-serif;
    }

    body {
        /* background: linear-gradient(90deg, #C7C5F4, #776BCC); */
        background-image: url('assets/pngtree-d-rendered-abstract-technology-big-data-flow-in-motion-for-transfer-picture-image_3703193.jpg');
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        /* height: 120%; */
        
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        width:100%;
    }

    .screen {
        background: linear-gradient(90deg, #5D54A4, #7C78B8);
        position: relative;
        height: 550px;
        width: 360px;
        box-shadow: 0px 0px 24px #5C5696;
    }

    .screen__content {
        z-index: 1;
        position: relative;
        height: 100%;
    }

    .screen__background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
        -webkit-clip-path: inset(0 0 0 0);
        clip-path: inset(0 0 0 0);
    }

    .screen__background__shape {
        transform: rotate(45deg);
        position: absolute;
    }

    .screen__background__shape1 {
        height: 520px;
        width: 520px;
        background: #FFF;
        top: -50px;
        right: 120px;
        border-radius: 0 72px 0 0;
    }

    .screen__background__shape2 {
        height: 220px;
        width: 220px;
        background: #6C63AC;
        top: -172px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape3 {
        height: 540px;
        width: 190px;
        background: linear-gradient(270deg, #5D54A4, #6A679E);
        top: -24px;
        right: 0;
        border-radius: 32px;
    }

    .screen__background__shape4 {
        height: 400px;
        width: 200px;
        background: #7E7BB9;
        top: 420px;
        right: 50px;
        border-radius: 60px;
    }

    .login {
        width: 320px;
        padding: 30px;
        padding-top: 20px;
    }

    .login__field {
        padding: 20px 0px;
        margin-left: 20px;
        position: relative;
    }

    .login__icon {
        position: absolute;
        top: 30px;
        color: #7875B5;
    }

    .login__input {
        border: none;
        border-bottom: 2px solid #D1D1D4;
        background: none;
        padding: 10px;
        padding-left: 24px;
        font-weight: 700;
        width: 90%;
        transition: .2s;
    }

    .login__input:active,
    .login__input:focus,
    .login__input:hover {
        outline: none;
        border-bottom-color: #6A679E;
    }

    .login__submit {
        background: #fff;
        font-size: 14px;
        margin-top: 30px;
        padding: 16px 20px;
        border-radius: 26px;
        border: 1px solid #D4D3E8;
        text-transform: uppercase;
        font-weight: 700;
        display: flex;
        align-items: center;
        width: 80%;
        color: #4C489D;
        box-shadow: 0px 2px 2px #5C5696;
        cursor: pointer;
        transition: .2s;
    }

    .login__submit:active,
    .login__submit:focus,
    .login__submit:hover {
        border-color: #6A679E;
        outline: none;
    }

    .button__icon {
        font-size: 24px;
        margin-left: auto;
        color: #7875B5;
    }

    .social-login {
        position: absolute;
        height: 140px;
        width: 160px;
        text-align: center;
        bottom: 0px;
        right: 0px;
        color: #fff;
    }

    .social-icons {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .social-login__icon {
        padding: 20px 10px;
        color: #fff;
        text-decoration: none;
        text-shadow: 0px 0px 8px #7875B5;
    }

    .social-login__icon:hover {
        transform: scale(1.5);
    }
</style>

<div class="container">
    <div class="screen">
        <?php if ($this->session->flashdata('notif')) {
            echo $this->session->flashdata('notif');
        } ?>
        <div class="screen__content">
      
            <div>
                <img style="width: 120px;padding:20px" src="<?= base_url('assets/') ?>logo-getlink.png" alt="">
            <b style="color:black; font-size:18px;"><u>MYGETLINK APPS</u></b>
            </div>
            <?= form_open('auth'); ?>
            <div class="login__field">
                <div class="login__icon">
                    <i class=" fas fa fa-user" style="font-size: 20px; padding-left:10px;"></i>
                </div>
                <input type="text" name="username" style="padding-left:40px;" class="login__input" placeholder="User Name">
                <small class="text-danger"><?= form_error('username') ?></small>
            </div>
            <div class="login__field">
                <div class="login__icon">
                    <i class=" fas fa fa-lock" style="font-size: 20px; padding-left:10px;"></i>
                </div>
                <input type="password" name="password" style="padding-left:40px;" class="login__input" placeholder="Password">
                <small class="text-danger"><?= form_error('password') ?></small>
            </div>
            <center>
                <?php echo $widget; ?>
                <?php echo $script; ?>
            </center>
            <center>
                <button class="button login__submit" type="submit">
                    <span class="button__text">LOGIN</span>
                    <div class="button__icon">
                        <i class="fa fa-sign-in"></i>
                    </div>
                </button>
            </center>
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
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>
</div>

</html>