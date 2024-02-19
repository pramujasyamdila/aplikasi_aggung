
<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use chriskacerguis\RestServer\RestController;
use Xendit\Xendit;

class Skripsi_api extends RestController
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Global_zahir/Global_zahir_model');
    $this->load->model('Auth_model');
    $this->load->library('xendit');
  }
  public function login_post()
  {
    $data = [
      'username' => $this->post('username'),
      'password' => $this->post('password')
    ];
    $cek = $this->Global_zahir_model->login($data['username']);
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
  public function uploadPoto_post()
  {
    $config['upload_path'] = './foto_user/';
    $config['allowed_types'] = 'jpeg|jpg|png|mp4';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file')) {
      $fileData = $this->upload->data();
      $upload = [
        'nama_user' => $this->post('username'),
        'username' => $this->post('username'),
        'alamat' => $this->post('alamat'),
        'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
        'telepone' => $this->post('telepone'),
        'no_rekening' => $this->post('no_rekening'),
        'nama_rekening' => $this->post('nama_rekening'),
        'id_role' => $this->post('id_role'),
        'file' => $fileData['file_name'],
        'status' => 1
      ];
      $this->Global_zahir_model->add_user($upload);
      $type = 'daftar_baru';
      $message = 'Hallo ' . $this->post('username') . ' Pendaftaran Anda Berhasil Reseller Redoors Anda Berhasil';
      $this->kirim_wa->kirim_wa($type, $this->post('telepone'), $message);
      $this->response([
        'status' => true,
        'data' => $fileData['file_name'],
        'message' => 'Success Register'
      ], RestController::HTTP_OK);
    }
  }

  public function updateTokenNotif_post()
  {
    $id_user = $this->post('id_user');
    $token_notif = $this->post('token_notif');
    $whereuser = [
      'id_user' => $id_user
    ];
    $datakirim = [
      'token_notif' => $token_notif,
    ];
    $this->Global_zahir_model->update_user($datakirim, $whereuser);
    if ($id_user) {
      $this->response([
        'status' => true,
        'data' => 'success',
        'message' => 'Token Update'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'Token Gagal Update'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambilPegawaiRow_get($id_user)
  {
    $toko =  $this->Global_zahir_model->get_user($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your User'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_produk_get()
  {
    $toko = $this->Global_zahir_model->result_produk();
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function satu_produk_get($id_produk)
  {
    $toko = $this->Global_zahir_model->row_produk($id_produk);
    $rating = $this->Global_zahir_model->get_rating($id_produk);
    $komentar = $this->Global_zahir_model->get_komentar($id_produk);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'rating' => $rating,
        'komentar' => $komentar,
        'message' => 'Found Your voucher'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA voucher'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_gambar_detail_produk_get($id_produk)
  {
    $toko = $this->Global_zahir_model->row_produk_gambar($id_produk);
    $rating = $this->Global_zahir_model->get_rating($id_produk);
    $komentar = $this->Global_zahir_model->get_komentar($id_produk);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'rating' => $rating,
        'komentar' => $komentar,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }



  public function addChart_post()
  {
    $data = [
      'id_produk' => $this->post('id_produk'),
      'jumlah_pesanan' => $this->post('jumlah_pesanan'),
      'id_user' => $this->post('id_user')
    ];
    $id_produk = $this->post('id_produk');
    $id_user = $this->post('id_user');
    $whereuser = [
      'id_user' => $id_user
    ];
    $datakirim = [
      'sts_invoice' => 1,
    ];
    $this->Global_zahir_model->update_user($datakirim, $whereuser);
    $data_keranjangcek =  $this->Global_zahir_model->cek_keranjnag($id_produk, $id_user);
    if ($data_keranjangcek) {
      $ambil_qty = $data_keranjangcek['jumlah_pesanan'];
      $total_pesanan = $ambil_qty + $this->post('jumlah_pesanan');
      $where = [
        'id_user' => $id_user,
        'id_produk' => $id_produk
      ];
      $datakirim = [
        'jumlah_pesanan' => $total_pesanan

      ];
      $this->Global_zahir_model->update_to_cart($where, $datakirim);
      $this->response([
        'status' => true,
        'message' => 'Keranjang Berhasil Di Update'
      ], RestController::HTTP_OK);
    } else {
      if ($data) {
        $this->Global_zahir_model->add_to_cart($data);
        $this->response([
          'status' => true,
          'data' => $data,
          'message' => 'Keranjang Berhasil Di Tambah'
        ], RestController::HTTP_OK);
      } else {
        $this->response([
          'status' => false,
          'message' => 'Gagal Menambah'
        ], RestController::HTTP_NOT_FOUND);
      }
    }
  }


  public function cekKeranjnag_get($id_user)
  {
    $toko =  $this->Global_zahir_model->cek_keranjnag_saya($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Keranjnag'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA VOUCHER DI KERANJANG'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function removeChart_post($id_cart)
  {
    $cek_keranjnag =  $this->Global_zahir_model->cek_keranjnagbyid($id_cart);
    $ambil_qty = $cek_keranjnag['jumlah_pesanan'];
    if ($ambil_qty == 1) {
      $this->Global_zahir_model->delete_to_cart($id_cart);
      $this->response([
        'status' => true,
        'message' => 'Keranjang Berhasil Di Delete'
      ], RestController::HTTP_OK);
    } else {
      $total_pesanan = $ambil_qty - 1;
      $where = [
        'id_cart' => $id_cart,
      ];
      $datakirim = [
        'jumlah_pesanan' => $total_pesanan

      ];
      $this->Global_zahir_model->update_to_cart($where, $datakirim);
      $this->response([
        'status' => true,
        'message' => 'Keranjang Berhasil Di Update'
      ], RestController::HTTP_OK);
    }
  }

  public function subTotal_get($id_user)
  {
    $toko =  $this->Global_zahir_model->cek_keranjnag_saya($id_user);
    $subtotal = 0;
    foreach ($toko as $key => $value) {
      $subtotal += $value['harga_produk'] * $value['jumlah_pesanan'];
    }
    if ($toko) {
      $this->response([
        'status' => true,
        'total' => $subtotal,
        'message' => 'Found Your Keranjnag'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
      ], RestController::HTTP_NOT_FOUND);
    }
  }


  function Kirim_pesananku_post()
  {
    $table = "tbl_produk_transaksi";
    $field = "no_order";
    $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
    $text =  $tahun . '.' . $bulan . '.ICST.PO.';
    $kode_terakhirnya = $this->Global_zahir_model->get_kode_po($text, $table, $field);
    $no_urut = (int) substr($kode_terakhirnya, -4, 4);
    $no_urut++;
    $no_order = $text . sprintf('%04s', $no_urut);
    $id_user =  5;
    $total_pesanan =  $this->post('total_pesanan');
    $fee_reseller =  $this->post('fee_reseller');
    $nama_pemesan =  $this->post('nama_pemesan');
    $telepon_pemesan =  $this->post('telepon_pemesan');
    $metode_pembayaran =  $this->post('metode_pembayaran');
    $keterangan =  'Pembelian Kamar';
    $row_user = $this->Global_zahir_model->get_user($id_user);
    $result_keranjang = $this->Global_zahir_model->cek_keranjnag_saya($id_user);
    $items = array();
    foreach ($result_keranjang as $key => $value) {
      $items = array(
        'name' => $value['nama_produk'],
        'quantity' => $value['jumlah_pesanan'],
        'price' => $value['harga_produk'],
        'url' => 'https=>//yourcompany.com/example_item'
      );
    }
    Xendit::setApiKey('xnd_development_K1sEbHYgnG5ZF8VKNVWXPNgW11aglxnQywuTOSQbcdQDgVQ0wcrL3Kj5hY09ty');
    $params = [
      'external_id' => $no_order,
      'amount' => $total_pesanan,
      'description' => $keterangan,
      'invoice_duration' => 86400,
      'customer' => [
        'given_names' => $row_user['username'],
        'email' => $row_user['email'],
        'mobile_number' => $row_user['telepone'],
        'addresses' => [
          [
            'city' => $row_user['alamat'],
            'country' => 'Indonesia',
            'postal_code' => '12345',
            'state' => 'Daerah Khusus Ibukota Jakarta',
            'street_line1' => 'Jalan Makan',
            'street_line2' => 'Kecamatan Kebayoran Baru'
          ]
        ]
      ],
      'customer_notification_preference' => [
        'invoice_created' => [
          'whatsapp',
        ],
        'invoice_reminder' => [
          'whatsapp',
        ],
        'invoice_paid' => [
          'whatsapp',
        ],
        'invoice_expired' => [
          'whatsapp',
        ]
      ],
      'success_redirect_url' => '' . base_url('customer/pembayaranberhasil') . '',
      'failure_redirect_url' => '' . base_url('customer/gagal_pesanan') . '',
      'currency' => 'IDR',
      'items' => [$items],
      'fees' => [
        [
          'type' => 'ADMIN',
          'value' => 5000
        ]
      ]
    ];

    $createInvoice = \Xendit\Invoice::create($params);
    $where = [
      'id_user' => $id_user
    ];
    $datakirim = [
      'url_invoice_user' => $createInvoice['invoice_url'],
    ];
    $this->Global_zahir_model->update_user($datakirim, $where);
    $upload = [
      'no_order' => $no_order,
      'id_user' => $id_user,
      'status_pesanan' => 1,
      'total_pesanan' => $total_pesanan,
      'metode_pembayaran' => $metode_pembayaran,
      'keterangan' => $keterangan,
      'fee_reseller' => $fee_reseller,
      'nama_pemesan' => $nama_pemesan,
      'telepon_pemesan' => $telepon_pemesan,
      'invoice_url' => $createInvoice['invoice_url'],
      'sts_pembayaran' => $createInvoice['status'],
      'expired' => $createInvoice['expiry_date'],
      'order_url' => 'https://e-cuti.kintekindo.net/master/pembayaran_cod/' . $no_order . '',
    ];
    $this->Global_zahir_model->tambah_ke_tbl_produk_transaksi($upload);
    $result_keranjang = $this->Global_zahir_model->cek_keranjnag_saya($id_user);
    foreach ($result_keranjang as $key => $value) {
      $data_table_detail = array(
        'no_order' => $no_order,
        'id_produk' => $value['id_produk'],
        'jumlah_pesanan' => $value['jumlah_pesanan'],
      );
      $this->Global_zahir_model->tambah_ke_tbl_produk_detail_transaksi($data_table_detail);
    }
    $this->db->delete('tbl_produk_keranjang', ['id_user' => $id_user]);
    return $this->db->affected_rows();
    $this->response([
      'status' => true,
      'message' => 'Berhasil Melakukan Pemesanan',
      'keranjang' => 'Ada',
    ], RestController::HTTP_OK);
  }


  function Kirim_pesananku_cod_post()
  {
    $table = "tbl_produk_transaksi";
    $field = "no_order";
    $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
    $text =  $tahun . '.' . $bulan . '.ICST.PO.';
    $kode_terakhirnya = $this->Global_zahir_model->get_kode_po($text, $table, $field);
    $no_urut = (int) substr($kode_terakhirnya, -4, 4);
    $no_urut++;
    $no_order = $text . sprintf('%04s', $no_urut);
    $id_user =  $this->post('id_user');
    $total_pesanan =  $this->post('total_pesanan');
    $fee_reseller =  $this->post('fee_reseller');
    $nama_pemesan =  $this->post('nama_pemesan');
    $telepon_pemesan =  $this->post('telepon_pemesan');
    $metode_pembayaran =  $this->post('metode_pembayaran');
    $keterangan =  'Pembelian Kamar';
    $result_keranjang = $this->Global_zahir_model->cek_keranjnag_saya($id_user);
    $upload = [
      'no_order' => $no_order,
      'id_user' => $id_user,
      'status_pesanan' => 1,
      'sts_pembayaran' => 'PENDING',
      'total_pesanan' => $total_pesanan,
      'metode_pembayaran' => $metode_pembayaran,
      'fee_reseller' => $fee_reseller,
      'nama_pemesan' => $nama_pemesan,
      'telepon_pemesan' => $telepon_pemesan,
      'order_url' => 'https://e-cuti.kintekindo.net/master/pembayaran_cod/' . $no_order . '',
      'invoice_url' => 'https://e-cuti.kintekindo.net/master/pembayaran_cod/' . $no_order . '',
      'keterangan' => $keterangan,
    ];
    $this->Global_zahir_model->tambah_ke_tbl_produk_transaksi($upload);
    $where = [
      'id_user' => $id_user
    ];
    $datakirim = [
      'no_order_terupdate' => 'https://e-cuti.kintekindo.net/master/pembayaran_cod/' . $no_order . '',
    ];
    $this->Global_zahir_model->update_user($datakirim, $where);
    $result_keranjang = $this->Global_zahir_model->cek_keranjnag_saya($id_user);
    foreach ($result_keranjang as $key => $value) {
      $data_table_detail = array(
        'no_order' => $no_order,
        'id_produk' => $value['id_produk'],
        'jumlah_pesanan' => $value['jumlah_pesanan'],
      );
      $this->Global_zahir_model->tambah_ke_tbl_produk_detail_transaksi($data_table_detail);
    }
    $this->db->delete('tbl_produk_keranjang', ['id_user' => $id_user]);
    return $this->db->affected_rows();
    $this->response([
      'status' => true,
      'message' => 'Berhasil Melakukan Pemesanan',
      'keranjang' => 'Ada',
    ], RestController::HTTP_OK);
  }



  public function ambil_iklan_get()
  {
    $toko = $this->Global_zahir_model->result_iklan();
    $toko1 = $this->Global_zahir_model->result_iklan();
    $toko2 = $this->Global_zahir_model->result_iklan();
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'data1' => $toko1,
        'data2' => $toko2,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_iklan_langganan_get()
  {
    $toko = $this->Global_zahir_model->result_iklan_langganan();
    $toko1 = $this->Global_zahir_model->result_iklan_langganan();
    $toko2 = $this->Global_zahir_model->result_iklan_langganan();
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'data1' => $toko1,
        'data2' => $toko2,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }


  // API PEMBELI
  public function cekOrderanPembeli_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_orderan_pemebeli($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }


  public function cekOrderanProsesPembeli_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_orderan_prosess_pembeli($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
  public function cekOrderanSelesaiPembeli_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_orderan_selesai_pembeli($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function cekOrderanPembayaranPembeli_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_orderan_pembayarn_pembeli($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }


  public function Penilain_post()
  {
    $no_order = $this->post('no_order');
    $ratingdetail = $this->post('ratingdetail');
    $komentar = $this->post('komentar');
    $id_user = $this->post('id_user');
    $result_detail_transaksi = $this->Global_zahir_model->get_detail_transaksi($no_order);
    foreach ($result_detail_transaksi as $key => $value) {
      $data_table_detail = array(
        'id_produk' => $value['id_produk'],
        'nilai_rating' => $ratingdetail,
        'komentar' => $komentar,
        'id_user' => $id_user,

      );
      $this->Global_zahir_model->tambah_ke_detail_rating_dan_komentar($data_table_detail);
    }
    $this->response([
      'status' => true,
      'message' => 'Found Your Keranjnag'
    ], RestController::HTTP_OK);
  }

  // AMBIL TRANSKASI DETAIL PER NO_ORDER
  public function OrderanDetail_get($no_order)
  {
    $toko =  $this->Global_zahir_model->get_detail_transaksi($no_order);
    $row_transaksi =  $this->Global_zahir_model->get_row_transaksi($no_order);
    $subtotal = 0;
    foreach ($toko as $key => $value) {
      $subtotal += $value['harga_produk'] * $value['jumlah_pesanan'];
    }
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'grandtotal' => $subtotal,
        'row_transaksi' => $row_transaksi,
        'message' => 'Found Your Keranjnag'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
      ], RestController::HTTP_NOT_FOUND);
    }
  }
  public function ambil_produk_user_post()
  {
    $id_produk = $this->post('id_produk');
    $id_user = $this->post('id_user');
    $toko = $this->Global_zahir_model->result_produk_user($id_produk, $id_user);
    $toko1 = $this->Global_zahir_model->result_produk_user_terjual($id_produk, $id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'data1' => $toko1,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_produk_user_byid_get($id_detail_produk_user)
  {
    $toko = $this->Global_zahir_model->row_produk_userbyid($id_detail_produk_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your voucher'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA voucher'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_produk_user_get($id_user)
  {
    $toko = $this->Global_zahir_model->total_produk_user_keseluruhan($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your voucher'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA voucher'
      ], RestController::HTTP_NOT_FOUND);
    }
  }



  public function update_detail_produk_get($id_detail_produk_user)
  {
    $where = [
      'id_detail_produk_user' => $id_detail_produk_user
    ];
    $data = [
      'sts_terjual' => 1,
    ];
    $this->Global_zahir_model->update_data_produk_user($data, $where);
    $this->response([
      'status' => true,
      'message' => 'Found Your voucher'
    ], RestController::HTTP_OK);
  }
  // voucher konter
  public function ambil_produk_konter_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_produk_konter($id_user);
    $toko1 = $this->Global_zahir_model->result_produk_konter($id_user);
    $toko2 = $this->Global_zahir_model->result_produk_konter($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'data1' => $toko1,
        'data2' => $toko2,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function ambil_myproduk_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_my_produk($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }




  public function ambil_paket_langganan_get()
  {
    $paket_langganan = $this->Global_zahir_model->result_paket_langganan();
    if ($paket_langganan) {
      $this->response([
        'status' => true,
        'data' => $paket_langganan,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function satu_paket_langganan_get($id_produk)
  {
    $toko = $this->Global_zahir_model->row_paket_langganan($id_produk);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your voucher'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA voucher'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function daftar_langganan_post($id_user)
  {
    $get_user =  $this->Global_zahir_model->get_user($id_user);
    $type = 'daftar_baru';
    $message = 'Permintaan Paket Berlangganan , Silakan Cek User : ' . $get_user['nama_user'] . ' Apakah Lokasi User Strategis Untuk Pemasangan';
    $this->kirim_wa->kirim_wa($type, '08978201075', $message);
    $data = [
      'nama_user' => $this->post('nama_user'),
      'email' => $this->post('email'),
      'telepone' => $this->post('telepone'),
      'alamat' => $this->post('alamat'),
      'status_berlangganan' => 1,
      'id_paket_bulanan_pilihan' => $this->post('id_paket_bulanan_pilihan'),
    ];
    $whereuser = [
      'id_user' => $id_user
    ];
    $this->Global_zahir_model->update_user($data, $whereuser);
    $this->response(
      [
        'status' => true,
        'data' => 'success'
      ],
      RestController::HTTP_OK
    );
  }

  public function riwayat_taggihan_belum_bayar_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_riwayat_taggihan($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function riwayat_taggihan_prosess_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_riwayat_taggihan_prosess($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function riwayat_taggihan_selesai_get($id_user)
  {
    $toko = $this->Global_zahir_model->result_riwayat_taggihan_selesai($id_user);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }


  public function riwayat_taggihan_detail_get($id_riwayat_pemabayaran)
  {
    $toko = $this->Global_zahir_model->result_riwayat_taggihan_detail($id_riwayat_pemabayaran);
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'message' => 'Found Your Order'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA Orderan'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function uploadPotobuktitaggihan_post()
  {
    $config['upload_path'] = './foto_user_pembayaran/';
    $config['allowed_types'] = 'jpeg|jpg|png|mp4';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);
    if ($this->upload->do_upload('file')) {
      $fileData = $this->upload->data();
      $where = [
        'id_riwayat_pemabayaran' => $this->post('id_riwayat_pemabayaran'),
      ];
      $upload = [
        'status_bayar' => 2,
        'file' => $fileData['file_name'],
      ];
      $get_taggihan =  $this->Global_zahir_model->by_id_riwayat_pemabayaran($this->post('id_riwayat_pemabayaran'));
      $type = 'pembayaran';
      $message = 'Pembayaran Taggihan : ' . $get_taggihan['ket_pembayaran'] . ' Dari User : ' . $get_taggihan['nama_user'] . ' Silakan Cek Pembayaran https://enkrip.kintekindo.net/foto_user_pembayaran/' . $fileData['file_name'] . '';
      $this->kirim_wa->kirim_wa($type, $get_taggihan['id_user'], $message);
      $this->Global_zahir_model->update_bukti_bayar($upload, $where);
      $this->response([
        'status' => true,
        'data' => $fileData['file_name'],
        'message' => 'Success Register'
      ], RestController::HTTP_OK);
    }
  }

  
  public function filter_produk_post()
  {
      $nama_produk = $this->post('nama_produk');
      $toko = $this->Global_zahir_model->result_produk_filter($nama_produk);
      if ($toko) {
          $this->response([
              'status' => true,
              'data' => $toko,
              'message' => 'Found Your Produk'
          ], RestController::HTTP_OK);
      } else {
          $this->response([
              'status' => false,
              'message' => 'MAAF BELUM ADA PRODUK'
          ], RestController::HTTP_NOT_FOUND);
      }
  }

}
