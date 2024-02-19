<!-- <div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img class="img-fluid mb-4" width="200px" style="margin-top: -20px;" src="<?= base_url('assets/') ?>gain.png" alt="">
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            Icost
        </div> -->
<style>
  .container {
    display: flex;
    /* Membuat kontainer menjadi flex container */
    align-items: center;
    /* Mengatur teks dan gambar secara vertikal di tengah */
  }

  .admin-text {
    margin-left: 10px;
    /* Mengatur jarak antara gambar dan teks */

  }
</style>
<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="">APLIKASI RECUITER PEKERJAAN</a>
    </div>
    <hr>
    <ul class="sidebar-menu">
      <li class="nav-item dropdown">
        <a href="<?= base_url('dashboard') ?>" class="nav-link"><i class="fas fa-home"></i> <span>Dashboard</span></a>
      </li>
      <ul class="sidebar-menu">
        <li class="nav-item dropdown">
          <a href="<?= base_url('spk/data_pelamar') ?>" class="nav-link"><i class="fas fa-file"></i> <span>Data Pelamar</span></a>
        </li>
        <li class="nav-item dropdown">
          <a href="<?= base_url('spk/data_kandidat') ?>" class="nav-link"><i class="fas fa-users"></i> <span>Data Kandidat</span></a>
        </li>
        <li class="nav-item dropdown">
          <a href="<?= base_url('spk/generate_hasil') ?>" class="nav-link"><i class="fa fa-anchor" aria-hidden="true"></i> <span>Generate Hasil</span></a>
        </li>
        <br>
        <li class="sidebar-menu nav-link">
          <a class="btn btn-danger" href="<?= base_url('auth/logout') ?>" onclick="return(confirm('Anda Akan Keluar Dari Halaman Aplikasi'))"><i style="color:white" class="far nav-icon fas fa-sign-out-alt"></i>
            <h6 class="my-4" style="color:white">Logout</h6>
          </a>
        </li>
  </aside>
</div>