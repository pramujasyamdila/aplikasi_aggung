
<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

use chriskacerguis\RestServer\RestController;
use Xendit\Xendit;

class Gain_api extends RestController
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('Global/Global_model');
    $this->load->model('Auth_model');
    $this->load->library('xendit');
  }
  public function login_post()
  {
    $data = [
      'username' => $this->post('username'),
      'password' => $this->post('password')
    ];
    $cek = $this->Global_model->login($data['username']);
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
        'email' => $this->post('email'),
        'alamat' => $this->post('alamat'),
        'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
        'telepone' => $this->post('telepone'),
        'kode_referal' => $this->post('kode_referal'),
        'id_role' => $this->post('id_role'),
        'status_berlangganan' => 2,
        'file' => $fileData['file_name'],
      ];
      $this->Global_model->add_user($upload);
      $type = 'daftar_baru';
      $message = 'Hallo ' . $this->post('username') . ' Pendaftaran Anda Berhasil Kami Akan Lakukan Pengecekan Sinyal Di Lokasi Anda Terlebih Dahulu , Setelah Itu Kami Akan Berikan Informasi Melalui Whataasp Nanti';
      $this->kirim_wa->kirim_wa($type, $this->post('telepone'), $message);
      $this->response([
        'status' => true,
        'data' => $fileData['file_name'],
        'message' => 'Success Register'
      ], RestController::HTTP_OK);
    }
  }

  public function ambilPegawaiRow_get($id_user)
  {
    $toko =  $this->Global_model->get_user($id_user);
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

  public function ambil_voucher_get()
  {
    $toko = $this->Global_model->result_voucher();
    $toko1 = $this->Global_model->result_voucher();
    $toko2 = $this->Global_model->result_voucher();
    $toko3 = $this->Global_model->result_voucher_landing();
    if ($toko) {
      $this->response([
        'status' => true,
        'data' => $toko,
        'data1' => $toko1,
        'data2' => $toko2,
        'data3' => $toko3,
        'message' => 'Found Your Produk'
      ], RestController::HTTP_OK);
    } else {
      $this->response([
        'status' => false,
        'message' => 'MAAF BELUM ADA PRODUK'
      ], RestController::HTTP_NOT_FOUND);
    }
  }

  public function satu_voucher_get($id_voucher)
  {
    $toko = $this->Global_model->row_voucher($id_voucher);
    $rating = $this->Global_model->get_rating($id_voucher);
    $komentar = $this->Global_model->get_komentar($id_voucher);
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


  public function addChart_post()
  {
    $data = [
      'id_voucher' => $this->post('id_voucher'),
      'jumlah_pesanan' => $this->post('jumlah_pesanan'),
      'id_user' => $this->post('id_user')
    ];
    $id_voucher = $this->post('id_voucher');
    $id_user = $this->post('id_user');
    $whereuser = [
      'id_user' => $id_user
    ];
    $datakirim = [
      'sts_invoice' => 1,
    ];
    $this->Global_model->update_user($datakirim, $whereuser);
    $data_keranjangcek =  $this->Global_model->cek_keranjnag($id_voucher, $id_user);
    if ($data_keranjangcek) {
      $ambil_qty = $data_keranjangcek['jumlah_pesanan'];
      $total_pesanan = $ambil_qty + $this->post('jumlah_pesanan');
      $where = [
        'id_user' => $id_user,
        'id_voucher' => $id_voucher
      ];
      $datakirim = [
        'jumlah_pesanan' => $total_pesanan

      ];
      $this->Global_model->update_to_cart($where, $datakirim);
      $this->response([
        'status' => true,
        'message' => 'Keranjang Berhasil Di Update'
      ], RestController::HTTP_OK);
    } else {
      if ($data) {
        $this->Global_model->add_to_cart($data);
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
    $toko =  $this->Global_model->cek_keranjnag_saya($id_user);
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
    $cek_keranjnag =  $this->Global_model->cek_keranjnagbyid($id_cart);
    $ambil_qty = $cek_keranjnag['jumlah_pesanan'];
    if ($ambil_qty == 1) {
      $this->Global_model->delete_to_cart($id_cart);
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
      $this->Global_model->update_to_cart($where, $datakirim);
      $this->response([
        'status' => true,
        'message' => 'Keranjang Berhasil Di Update'
      ], RestController::HTTP_OK);
    }
  }

  public function subTotal_get($id_user)
  {
    $toko =  $this->Global_model->cek_keranjnag_saya($id_user);
    $subtotal = 0;
    foreach ($toko as $key => $value) {
      $subtotal += $value['harga_voucher'] * $value['jumlah_pesanan'];
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
    $table = "tbl_voucher_transaksi";
    $field = "no_order";
    $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
    $bulan = $array_bulan[date('n')];
    $tahun = date('Y');
    $text =  $tahun . '.' . $bulan . '.ICST.PO.';
    $kode_terakhirnya = $this->Global_model->get_kode_po($text, $table, $field);
    $no_urut = (int) substr($kode_terakhirnya, -4, 4);
    $no_urut++;
    $no_order = $text . sprintf('%04s', $no_urut);
    $id_user =  $this->post('id_user');
    $total_pesanan =  $this->post('total_pesanan');
    $keterangan =  'Pembelian Voucher I-Cost';
    $row_user = $this->Global_model->get_user($id_user);
    $result_keranjang = $this->Global_model->cek_keranjnag_saya($id_user);
    // $invoice = $row_user['sts_invoice'];
    // if ($invoice != 1) {
    $items = array();
    foreach ($result_keranjang as $key => $value) {
      $items = array(
        'name' => $value['nama_voucher'],
        'quantity' => $value['jumlah_pesanan'],
        'price' => $value['harga_voucher'],
        'url' => 'https=>//yourcompany.com/example_item'
      );
    }
    // Xendit::setApiKey('xnd_production_MbPiooozcF4Mdfb0sfL8ugyNQTuraeX8rGge8TGsSa8XHnNjBGWyo2vlOXlvykvD');
    Xendit::setApiKey('xnd_production_qfuav0JwRgwPEWAKfvceMnhJlDqXN0bs1gyqvU9TsFSsrDVd35bpGVvUaL7b');
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
          'sms',
          'email',
          'viber'
        ],
        'invoice_reminder' => [
          'whatsapp',
          'sms',
          'email',
          'viber'
        ],
        'invoice_paid' => [
          'whatsapp',
          'sms',
          'email',
          'viber'
        ],
        'invoice_expired' => [
          'whatsapp',
          'sms',
          'email',
          'viber'
        ]
      ],
      'success_redirect_url' => '' . base_url('customer/success_pesanan') . '',
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
    $this->Global_model->update_user($datakirim, $where);
    $upload = [
      'no_order' => $no_order,
      'id_user' => $id_user,
      'status_pesanan' => 1,
      'total_pesanan' => $total_pesanan,
      'keterangan' => $keterangan,
      'invoice_url' => $createInvoice['invoice_url'],
      'sts_pembayaran' => $createInvoice['status'],
      'expired' => $createInvoice['expiry_date'],
    ];
    $this->Global_model->tambah_ke_tbl_voucher_transaksi($upload);
    $result_keranjang = $this->Global_model->cek_keranjnag_saya($id_user);
    foreach ($result_keranjang as $key => $value) {
      $data_table_detail = array(
        'no_order' => $no_order,
        'id_voucher' => $value['id_voucher'],
        'jumlah_pesanan' => $value['jumlah_pesanan'],
      );
      $this->Global_model->tambah_ke_tbl_voucher_detail_transaksi($data_table_detail);
    }
    $this->db->delete('tbl_voucher_keranjang', ['id_user' => $id_user]);
    return $this->db->affected_rows();
    $this->response([
      'status' => true,
      'message' => 'Berhasil Melakukan Pemesanan',
      'keranjang' => 'Ada',
    ], RestController::HTTP_OK);
    // } else {
    //   $this->response([
    //     'status' => true,
    //     'message' => 'Berhasil Melakukan Pemesanan',
    //     'keranjang' => 'Sudah Ada Pesanan',
    //   ], RestController::HTTP_OK);
    // }
  }



  public function ambil_iklan_get()
  {
    $toko = $this->Global_model->result_iklan();
    $toko1 = $this->Global_model->result_iklan();
    $toko2 = $this->Global_model->result_iklan();
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
    $toko = $this->Global_model->result_iklan_langganan();
    $toko1 = $this->Global_model->result_iklan_langganan();
    $toko2 = $this->Global_model->result_iklan_langganan();
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
    $toko = $this->Global_model->result_orderan_pemebeli($id_user);
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
    $toko = $this->Global_model->result_orderan_prosess_pembeli($id_user);
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
    $toko = $this->Global_model->result_orderan_selesai_pembeli($id_user);
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
    $toko = $this->Global_model->result_orderan_pembayarn_pembeli($id_user);
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
    $result_detail_transaksi = $this->Global_model->get_detail_transaksi($no_order);
    foreach ($result_detail_transaksi as $key => $value) {
      $data_table_detail = array(
        'id_voucher' => $value['id_voucher'],
        'nilai_rating' => $ratingdetail,
        'komentar' => $komentar,
        'id_user' => $id_user,

      );
      $this->Global_model->tambah_ke_detail_rating_dan_komentar($data_table_detail);
    }
    $this->response([
      'status' => true,
      'message' => 'Found Your Keranjnag'
    ], RestController::HTTP_OK);
  }

  // AMBIL TRANSKASI DETAIL PER NO_ORDER
  public function OrderanDetail_get($no_order)
  {
    $toko =  $this->Global_model->get_detail_transaksi($no_order);
    $row_transaksi =  $this->Global_model->get_row_transaksi($no_order);
    $subtotal = 0;
    foreach ($toko as $key => $value) {
      $subtotal += $value['harga_voucher'] * $value['jumlah_pesanan'];
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
  public function ambil_voucher_user_post()
  {
    $id_voucher = $this->post('id_voucher');
    $id_user = $this->post('id_user');
    $toko = $this->Global_model->result_voucher_user($id_voucher, $id_user);
    $toko1 = $this->Global_model->result_voucher_user_terjual($id_voucher, $id_user);
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

  public function ambil_voucher_user_byid_get($id_detail_voucher_user)
  {
    $toko = $this->Global_model->row_voucher_userbyid($id_detail_voucher_user);
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

  public function ambil_voucher_user_get($id_user)
  {
    $toko = $this->Global_model->total_voucher_user_keseluruhan($id_user);
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



  public function update_detail_voucher_get($id_detail_voucher_user)
  {
    $where = [
      'id_detail_voucher_user' => $id_detail_voucher_user
    ];
    $data = [
      'sts_terjual' => 1,
    ];
    $this->Global_model->update_data_voucher_user($data, $where);
    $this->response([
      'status' => true,
      'message' => 'Found Your voucher'
    ], RestController::HTTP_OK);
  }
  // voucher konter
  public function ambil_voucher_konter_get($id_user)
  {
    $toko = $this->Global_model->result_voucher_konter($id_user);
    $toko1 = $this->Global_model->result_voucher_konter($id_user);
    $toko2 = $this->Global_model->result_voucher_konter($id_user);
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

  public function ambil_myvoucher_get($id_user)
  {
    $toko = $this->Global_model->result_my_voucher($id_user);
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
    $this->Global_model->update_user($datakirim, $whereuser);
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

  public function ambil_paket_langganan_get()
  {
    $paket_langganan = $this->Global_model->result_paket_langganan();
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

  public function satu_paket_langganan_get($id_voucher)
  {
    $toko = $this->Global_model->row_paket_langganan($id_voucher);
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
    $get_user =  $this->Global_model->get_user($id_user);
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
    $this->Global_model->update_user($data, $whereuser);
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
    $toko = $this->Global_model->result_riwayat_taggihan($id_user);
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
    $toko = $this->Global_model->result_riwayat_taggihan_prosess($id_user);
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
    $toko = $this->Global_model->result_riwayat_taggihan_selesai($id_user);
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
    $toko = $this->Global_model->result_riwayat_taggihan_detail($id_riwayat_pemabayaran);
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
      $get_taggihan =  $this->Global_model->by_id_riwayat_pemabayaran($this->post('id_riwayat_pemabayaran'));
      $type = 'pembayaran';
      $message = 'Pembayaran Taggihan : ' . $get_taggihan['ket_pembayaran'] . ' Dari User : ' . $get_taggihan['nama_user'] . ' Silakan Cek Pembayaran https://enkrip.kintekindo.net/foto_user_pembayaran/' . $fileData['file_name'] . '';
      $this->kirim_wa->kirim_wa($type, $get_taggihan['id_user'], $message);
      $this->Global_model->update_bukti_bayar($upload, $where);
      $this->response([
        'status' => true,
        'data' => $fileData['file_name'],
        'message' => 'Success Register'
      ], RestController::HTTP_OK);
    }
  }
}
