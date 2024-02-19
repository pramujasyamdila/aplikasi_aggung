<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Unit_kerja extends RestController
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Unit_kerja/Unit_kerja_model');
    $this->load->model('Paket/Paket_model');
    $this->load->model('Auth_model');
  }

  public function index_get()
  {
    $dataunit = $this->Unit_kerja_model->result_unit_kerja();
    $this->response(
      [
        'status' => true,
        'data' => $dataunit
      ],
      RestController::HTTP_OK
    );
  }

  public function paket_get($id)
  {
    $paket = $this->Unit_kerja_model->ambil_paket($id);
    if ($paket) {
      $this->response([
        'status' => true,
        'data' => $paket,
        'message' => 'Found Your Paket'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'Sorry Paket Yang Kamu Cari Gak Ada'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  // get vendor

  public function login_post()
  {
    $data = [
      'username' => $this->post('username'),
      'password' => $this->post('password')
    ];
    $cek = $this->Auth_model->login($data['username']);
    if ($cek && password_verify($data['password'], $cek->password)) {
      $this->response(
        [
          'status' => true,
          'data' => $cek
        ],
        RestController::HTTP_OK
      );
    } else {
      $this->response(
        [
          'status' => false,
          'pesan' => 'Maaf Username Atau Password Anda Salah !!!'
        ],
        RestController::HTTP_BAD_REQUEST
      );
    }
  }

  // INI AMBIL DATA VENDOR BY MENGIKUTI PAKET
  public function vendor_mengikuti_paket_get($id_paket)
  {
    $vendor = $this->Paket_model->ambil_semua_evaluasi($id_paket);
    if ($vendor) {
      $this->response([
        'status' => true,
        'data' => $vendor,
        'message' => 'Found Your vendor'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA VENDOR'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_pemenang_tender_get($id_paket)
  {
    $pemenang = $this->Paket_model->ambil_pemenang_tender($id_paket);
    if ($pemenang) {
      $this->response([
        'status' => true,
        'data' => $pemenang,
        'message' => 'Found Your pemenang'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA pemenang'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_vendor_get($id_vendor)
  {
    $vendor = $this->Paket_model->row_vendor($id_vendor);
    if ($vendor) {
      $this->response([
        'status' => true,
        'data' => $vendor,
        'message' => 'Found Your vendor'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA vendor'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
  public function vendor_dok_get()
  {
    $id_vendor = $this->get('id_vendor');
    $id_paket = $this->get('id_paket');
    $d_p_vendor = $this->Paket_model->result_dokumen_penawaran_vendor($id_paket, $id_vendor);
    $d_ph_vendor = $this->Paket_model->result_dokumen_penawaran_harga_vendor($id_paket, $id_vendor);
    $d_ps_vendor  = $this->Paket_model->result_tbl_vendor_persyaratan($id_paket, $id_vendor);
    $d_pnjk_vendor = $this->Paket_model->result_tbl_vendor_penunjukan($id_paket, $id_vendor);
    $this->response([
      'status' => true,
      'data' => [
        'dok_penawaran_v' => $d_p_vendor,
        'dok_penawaran_harga_v' => $d_ph_vendor,
        'dok_persyaratan_v' => $d_ps_vendor,
        'dok_penunjukan_v' => $d_pnjk_vendor
      ],
      'message' => 'Found Your Dokumen'
    ], RestController::HTTP_OK);
  }
  public function tender_dok_get($id_paket)
  {
    $rincian_hps =  $this->Paket_model->rincian_hps($id_paket);
    $dokumen_prakualifikasi =  $this->Paket_model->dokumen_prakualifikasi($id_paket);
    $dokumen_penunjang =  $this->Paket_model->dokumen_penunjang($id_paket);
    $dokumen_lelang =  $this->Paket_model->dokumen_lelang($id_paket);
    $dokumen_persyaratan =  $this->Paket_model->dokumen_persyaratan($id_paket);
    $dokumen_peringkat_teknis =  $this->Paket_model->dokumen_peringkat_teknis($id_paket);
    $dokumen_hasil_penawaran =  $this->Paket_model->dokumen_hasil_penawaran($id_paket);
    $dokumen_hasil_tender =  $this->Paket_model->dokumen_hasil_tender($id_paket);
    $dokumen_informasi_lainya =  $this->Paket_model->dokumen_informasi_lainya($id_paket);
    $dokume_surat_penunjukan =  $this->Paket_model->dokume_surat_penunjukan($id_paket);
    $this->response([
      'status' => true,
      'data' => [
        'rincian_hps' => $rincian_hps,
        'dokumen_prakualifikasi' => $dokumen_prakualifikasi,
        'dokumen_penunjang' => $dokumen_penunjang,
        'dokumen_lelang' => $dokumen_lelang,
        'dokumen_persyaratan' => $dokumen_persyaratan,
        'dokumen_peringkat_teknis' => $dokumen_peringkat_teknis,
        'dokumen_hasil_penawaran' => $dokumen_hasil_penawaran,
        'dokumen_hasil_tender' => $dokumen_hasil_tender,
        'dokumen_informasi_lainya' => $dokumen_informasi_lainya,
        'dokume_surat_penunjukan' => $dokume_surat_penunjukan,

      ],
      'message' => 'Found Your Dokumen'
    ], RestController::HTTP_OK);
  }

  public function all_vendor_get()
  {
    $vendor = $this->Paket_model->ambil_vendor();
    if ($vendor) {
      $this->response([
        'status' => true,
        'data' => $vendor,
        'message' => 'Found Your vendor'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA vendor'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  /*  Update Images*/

  // TAMBAH PEGAWAI
  public function tambah_toko_post()
  {
    $data = [
      'nama_toko' => $this->post('nama_toko'),
      'alamat_toko' => $this->post('alamat_toko'),
      'telpon_toko' => $this->post('telpon_toko')
    ];
    if ($data) {
      $this->Paket_model->create_toko($data);
      $this->response([
        'status' => true,
        'data' => $data,
        'message' => 'Toko Berhasil Di Tambah'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'Gagal Menambah'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
  public function ambil_toko_get()
  {
    $toko = $this->Paket_model->result_toko();
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Toko'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA TOKO'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function create_merk_produk_post()
  {
    $data = [
      'merk_produk' => $this->post('merk_produk'),
      'varian_produk' => $this->post('varian_produk'),
      'ukuran_produk' => $this->post('ukuran_produk')
    ];
    if ($data) {
      $this->Paket_model->create_merk($data);
      $this->response([
        'status' => true,
        'data' => $data,
        'message' => 'Merk Berhasil Di Tambah'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'Gagal Menambah'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
  public function ambil_merk_get()
  {
    $merk = $this->Paket_model->result_merk();
    if ($merk) {
      $this->response([
        'status' => true,
        'data' => $merk,
        'message' => 'Found Your Merk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA MERK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }


  public function ambil_vendorku_row_post()
  {
    $id_vendor = $this->post('id_vendor');
    $data = $this->Paket_model->row_vendor($id_vendor);
    $this->response([
      'status' => true,
      'data' => $data,
      'message' => 'Found Your Dokumen'
    ], RestController::HTTP_OK);
  }

  public function dokumen_verifikasi_get()
  {
    $id_vendor = $this->get('id_vendor');
    $tbl_vendor_izin_usaha =  $this->Paket_model->tbl_vendor_izin_usaha($id_vendor);
    $tbl_vendor_akta_pendirian =  $this->Paket_model->tbl_vendor_akta_pendirian($id_vendor);
    $tbl_vendor_pemilik =  $this->Paket_model->tbl_vendor_pemilik($id_vendor);
    $tbl_vendor_pengurus =  $this->Paket_model->tbl_vendor_pengurus($id_vendor);
    $tbl_vendor_tenaga_ahli =  $this->Paket_model->tbl_vendor_tenaga_ahli($id_vendor);
    $tbl_vendor_pengalaman =  $this->Paket_model->tbl_vendor_pengalaman($id_vendor);
    $tbl_vendor_pajak =  $this->Paket_model->tbl_vendor_pajak($id_vendor);
    $tbl_vendor_keuangan =  $this->Paket_model->tbl_vendor_keuangan($id_vendor);
    $tbl_vendor_tdp =  $this->Paket_model->tbl_vendor_tdp($id_vendor);
    $tbl_vendor_nib =  $this->Paket_model->tbl_vendor_nib($id_vendor);
    $tbl_vendor_siup =  $this->Paket_model->tbl_vendor_siup($id_vendor);
    $tbl_vendor_npwp =  $this->Paket_model->tbl_vendor_npwp($id_vendor);
    $tbl_vendor_skpkp =  $this->Paket_model->tbl_vendor_skpkp($id_vendor);
    $tbl_vendor_sppt =  $this->Paket_model->tbl_vendor_sppt($id_vendor);
    $tbl_vendor_siujk =  $this->Paket_model->tbl_vendor_siujk($id_vendor);
    $tbl_vendor_ktp =  $this->Paket_model->tbl_vendor_ktp($id_vendor);
    $tbl_vendor_sbu =  $this->Paket_model->tbl_vendor_sbu($id_vendor);
    $tbl_vendor_domisili =  $this->Paket_model->tbl_vendor_domisili($id_vendor);
    $tbl_vendor_bagan =  $this->Paket_model->tbl_vendor_bagan($id_vendor);
    $tbl_vendor_bpjs_ketenagakerjaan =  $this->Paket_model->tbl_vendor_bpjs_ketenagakerjaan($id_vendor);
    $tbl_vendor_bpjs_kesehatan =  $this->Paket_model->tbl_vendor_bpjs_kesehatan($id_vendor);

    $this->response([
      'status' => true,
      'data' => [
        'tbl_vendor_izin_usaha' => $tbl_vendor_izin_usaha,
        'tbl_vendor_akta_pendirian' => $tbl_vendor_akta_pendirian,
        'tbl_vendor_pemilik' => $tbl_vendor_pemilik,
        'tbl_vendor_pengurus' => $tbl_vendor_pengurus,
        'tbl_vendor_tenaga_ahli' => $tbl_vendor_tenaga_ahli,
        'tbl_vendor_pengalaman' => $tbl_vendor_pengalaman,
        'tbl_vendor_pajak' => $tbl_vendor_pajak,
        'tbl_vendor_keuangan' => $tbl_vendor_keuangan,
        'tbl_vendor_nib' => $tbl_vendor_nib,
        'tbl_vendor_tdp' => $tbl_vendor_tdp,
        'tbl_vendor_siup' => $tbl_vendor_siup,
        'tbl_vendor_npwp' => $tbl_vendor_npwp,
        'tbl_vendor_skpkp' => $tbl_vendor_skpkp,
        'tbl_vendor_sppt' => $tbl_vendor_sppt,
        'tbl_vendor_siujk' => $tbl_vendor_siujk,
        'tbl_vendor_ktp' => $tbl_vendor_ktp,
        'tbl_vendor_sbu' => $tbl_vendor_sbu,
        'tbl_vendor_domisili' => $tbl_vendor_domisili,
        'tbl_vendor_bagan' => $tbl_vendor_bagan,
        'tbl_vendor_bpjs_ketenagakerjaan' => $tbl_vendor_bpjs_ketenagakerjaan,
        'tbl_vendor_bpjs_kesehatan' => $tbl_vendor_bpjs_kesehatan,
      ],
      'message' => 'Found Your Dokumen'
    ], RestController::HTTP_OK);
  }

  public function cari_unit_kerja_post()
  {
    $nama_unit_kerja = $this->post('nama_unit_kerja');
    $nama_unit = $this->Paket_model->cari_unit($nama_unit_kerja);
    if ($nama_unit) {
      $this->response([
        'status' => true,
        'nama_unit' => $nama_unit,
        'message' => 'ADA DATA'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'GAK ADA DATA'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
  public function count_dashboard_get()
  {
    $paket = $this->Paket_model->count_paket();
    $vendor = $this->Paket_model->count_vendor();
    $unit = $this->Paket_model->count_unit();
    $this->response([
      'status' => true,
      'paketcount' => $paket,
      'vendorcounr' => $vendor,
      'unitcount' => $unit,
      'message' => 'ADA DATA'
    ], RestController::HTTP_OK);
  }

  public function uploadPoto_post()
  {
    $config['upload_path'] = './foto_user/';
    $config['allowed_types'] = 'jpeg|jpg|png|mp4';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file')) {
      $fileData = $this->upload->data();
      $upload = [
        'username' => $this->post('username'),
        'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
        'telepone' => $this->post('telepone'),
        'file' => $fileData['file_name'],
      ];
      $this->Paket_model->create_pegawai_prima($upload);
      $this->response([
        'status' => true,
        'data' => $fileData['file_name'],
        'message' => 'Success Register'
      ], RestController::HTTP_OK);
    }
  }

  public function produkUpload_post()
  {
    $config['upload_path'] = './foto_produk/';
    $config['allowed_types'] = 'jpeg|jpg|png|mp4';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file')) {
      $fileData = $this->upload->data();
      $upload = [
        'nama_produk' => $this->post('nama_produk'),
        'merk_produk' => $this->post('merk_produk'),
        'ukuran_produk' => $this->post('ukuran_produk'),
        'qty' => $this->post('qty'),
        'harga' => $this->post('harga'),
        'tanggal_expired' => $this->post('tanggal_expired'),
        'foto_produk' => $fileData['file_name'],
      ];
      $this->Paket_model->create_prima_produk($upload);
      $this->response([
        'status' => true,
        'data' => $fileData['file_name'],
        'message' => 'Success Register'
      ], RestController::HTTP_OK);
    }
  }
  public function ambil_produk_get()
  {
    $produk = $this->Paket_model->result_produk();
    if ($produk) {
      $this->response([
        'status' => true,
        'data' => $produk,
        'message' => 'Found Your produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA produk'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
}
