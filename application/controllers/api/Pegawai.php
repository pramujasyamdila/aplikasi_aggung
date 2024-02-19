<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use Xendit\Xendit;

class Pegawai extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Unit_kerja/Unit_kerja_model');
        $this->load->model('Paket/Paket_model');
        $this->load->model('Pegawai_angkringan/Pegawai_angkringan_model');
        $this->load->model('Auth_model');
    }

    public function index_get()
    {
        $dataunit = ['angga'];
        $this->response(
            [
                'status' => true,
                'data' => $dataunit
            ],
            RestController::HTTP_OK
        );
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
                'email' => $this->post('email'),
                'alamat' => $this->post('alamat'),
                'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
                'telepone' => $this->post('telepone'),
                'id_role' => $this->post('id_role'),
                'file' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->create_pegawai($upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function uploadPoto_nasdem_post()
    {
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'alamat' => $this->post('alamat'),
                'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
                'telepone' => $this->post('telepone'),
                'id_role' => 3,
                'file' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->create_pegawai($upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function login_post()
    {
        $data = [
            'username' => $this->post('username'),
            'password' => $this->post('password')
        ];
        $cek = $this->Pegawai_angkringan_model->login_pegawai_angkringan($data['username']);
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

    public function addChart_post()
    {
        $data = [
            'id_produk' => $this->post('id_produk'),
            'jumlah_pesanan' => $this->post('jumlah_pesanan'),
            'id_pegawai' => $this->post('id_pegawai')
        ];
        $id_produk = $this->post('id_produk');
        $id_pegawai = $this->post('id_pegawai');
        $data_keranjangcek =  $this->Pegawai_angkringan_model->cek_keranjnag($id_produk, $id_pegawai);
        if ($data_keranjangcek) {
            $ambil_qty = $data_keranjangcek['jumlah_pesanan'];
            $total_pesanan = $ambil_qty + $this->post('jumlah_pesanan');
            $where = [
                'id_pegawai' => $id_pegawai,
                'id_produk' => $id_produk
            ];
            $datakirim = [
                'jumlah_pesanan' => $total_pesanan

            ];
            $this->Pegawai_angkringan_model->update_to_cart($where, $datakirim);
            $this->response([
                'status' => true,
                'message' => 'Keranjang Berhasil Di Update'
            ], RestController::HTTP_OK);
        } else {
            if ($data) {
                $this->Pegawai_angkringan_model->add_to_cart($data);
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


    public function removeChart_post($id_cart)
    {
        $cek_keranjnag =  $this->Pegawai_angkringan_model->cek_keranjnagbyid($id_cart);
        $ambil_qty = $cek_keranjnag['jumlah_pesanan'];
        if ($ambil_qty == 1) {
            $this->Pegawai_angkringan_model->delete_to_cart($id_cart);
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
            $this->Pegawai_angkringan_model->update_to_cart($where, $datakirim);
            $this->response([
                'status' => true,
                'message' => 'Keranjang Berhasil Di Update'
            ], RestController::HTTP_OK);
        }
    }





    public function ambil_produk_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_produk();
        $toko1 = $this->Pegawai_angkringan_model->result_produk_food();
        $toko2 = $this->Pegawai_angkringan_model->result_produk_drink();
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

    public function filter_produk_post()
    {
        $nama_produk = $this->post('nama_produk');
        $toko = $this->Pegawai_angkringan_model->result_produk_filter($nama_produk);
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

    public function cekOrderan_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan();
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




    public function cekOrderanProses_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_prosess();
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
    public function cekOrderanSelesai_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_selesai();
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

    public function cekOrderanPembayaran_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_pembayarn();
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

    public function satu_produk_get($id_produk)
    {
        $toko = $this->Pegawai_angkringan_model->row_produk($id_produk);
        $rating = $this->Pegawai_angkringan_model->get_rating($id_produk);
        $komentar = $this->Pegawai_angkringan_model->get_komentar($id_produk);
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

    public function cekKeranjnag_get($id_pegawai)
    {
        $toko =  $this->Pegawai_angkringan_model->cek_keranjnag_saya($id_pegawai);
        if ($toko) {
            $this->response([
                'status' => true,
                'data' => $toko,
                'message' => 'Found Your Keranjnag'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
            ], RestController::HTTP_NOT_FOUND);
        }
    }




    public function subTotal_get($id_pegawai)
    {
        $toko =  $this->Pegawai_angkringan_model->cek_keranjnag_saya($id_pegawai);
        $subtotal = 0;
        foreach ($toko as $key => $value) {
            $subtotal += $value['harga'] * $value['jumlah_pesanan'];
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

    public function produkUpload_post()
    {
        $config['upload_path'] = './foto_produk/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_produk')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_produk' => $this->post('nama_produk'),
                'deskripsi' => $this->post('deskripsi'),
                'rating' => $this->post('rating'),
                'qty' => $this->post('qty'),
                'harga' => $this->post('harga'),
                'id_kategori' => $this->post('id_kategori'),
                'foto_produk' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->create_produk($upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Berhasil Mengupload Produk'
            ], RestController::HTTP_OK);
        }
    }


    public function kirimPesanan_post()
    {
        $table = "angkringan_transaksi";
        $field = "no_order";
        $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bulan = $array_bulan[date('n')];
        $tahun = date('Y');
        $text =  $tahun . '.' . $bulan . '.PCH.PO.';
        $kode_terakhirnya = $this->Pegawai_angkringan_model->get_kode_po($text, $table, $field);
        $no_urut = (int) substr($kode_terakhirnya, -4, 4);
        $no_urut++;
        $no_order = $text . sprintf('%04s', $no_urut);
        // INI UNTUK  BAGIAN POSTNYA UPDATE KE TBL_TRANSAKSI_PO
        $id_pegawai =  $this->post('id_pegawai');
        $metode_pembayaran =  $this->post('metode_pembayaran');
        $total_pesanan =  $this->post('total_pesanan');
        $config['upload_path'] = './bukti_pembayaran/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('bukti_pembayaran')) {
            $fileData = $this->upload->data();
            $upload = [
                'no_order' => $no_order,
                'id_pegawai' => $id_pegawai,
                'status_pesanan' => 1,
                'total_pesanan' => $total_pesanan,
                'metode_pembayaran' => $metode_pembayaran,
                'bukti_pembayaran' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->tambah_ke_angkringan_transaksi($upload);
            $result_keranjang = $this->Pegawai_angkringan_model->cek_keranjnag_saya($id_pegawai);
            foreach ($result_keranjang as $key => $value) {
                $data_table_detail = array(
                    'no_order' => $no_order,
                    'id_produk' => $value['id_produk'],
                    'jumlah_pesanan' => $value['jumlah_pesanan'],
                );
                $this->Pegawai_angkringan_model->tambah_ke_angkringan_detail_transaksi($data_table_detail);
            }
            $this->db->delete('angkringan_keranjang', ['id_pegawai' => $id_pegawai]);
            return $this->db->affected_rows();
            $this->response([
                'status' => true,
                'message' => 'Berhasil Melakukan Pemesanan'
            ], RestController::HTTP_OK);
        }
    }



    // AMBIL TRANSKASI DETAIL PER NO_ORDER
    public function OrderanDetail_get($no_order)
    {
        $toko =  $this->Pegawai_angkringan_model->get_detail_transaksi($no_order);
        $row_transaksi =  $this->Pegawai_angkringan_model->get_row_transaksi($no_order);
        $subtotal = 0;
        foreach ($toko as $key => $value) {
            $subtotal += $value['harga'] * $value['jumlah_pesanan'];
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
    public function Updatetransaksi_post()
    {
        $data = [
            'status_pesanan' => 2,
        ];
        $where = [
            'no_order' => $this->post('no_order')
        ];
        if ($data) {
            $this->Pegawai_angkringan_model->update_to_order($where, $data);
            $this->response([
                'status' => true,
                'message' => 'Found Your Keranjnag'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function UpdateProses_post()
    {
        $data = [
            'status_pesanan' => 3,
        ];
        $where = [
            'no_order' => $this->post('no_order')
        ];
        if ($data) {
            $this->Pegawai_angkringan_model->update_to_order($where, $data);
            $this->response([
                'status' => true,
                'message' => 'Found Your Keranjnag'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function UpdateProsesTransfer_post()
    {
        $data = [
            'status_pesanan' => 4,
        ];
        $where = [
            'no_order' => $this->post('no_order')
        ];
        if ($data) {
            $this->Pegawai_angkringan_model->update_to_order($where, $data);
            $this->response([
                'status' => true,
                'message' => 'Found Your Keranjnag'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
            ], RestController::HTTP_NOT_FOUND);
        }
    }



    public function Bayartransaksi_post()
    {
        $no_order = $this->post('no_order');
        $result_keranjang =  $this->Pegawai_angkringan_model->get_detail_transaksi($no_order);
        foreach ($result_keranjang as $key => $value) {
            $dimaana = array(
                'id_produk' => $value['id_produk'],
            );
            $data_table_detail = array(
                'qty' => $value['qty'] - $value['jumlah_pesanan'],
            );
            $this->Pegawai_angkringan_model->update_ke_produk($dimaana, $data_table_detail);
        }
        $data = [
            'status_pesanan' => 4,
            'harga_bayar' => $this->post('harga_bayar'),
            'kembalian' => $this->post('kembalian'),
        ];
        $where = [
            'no_order' => $this->post('no_order')
        ];

        if ($data) {
            $this->Pegawai_angkringan_model->update_to_order($where, $data);
            $this->response([
                'status' => true,
                'message' => 'Found Your Keranjnag'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA PRODUK DI KERANJANG'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    // API PEMBELI

    public function cekOrderanPembeli_get($id_pegawai)
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_pemebeli($id_pegawai);
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


    public function cekOrderanProsesPembeli_get($id_pegawai)
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_prosess_pembeli($id_pegawai);
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
    public function cekOrderanSelesaiPembeli_get($id_pegawai)
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_selesai_pembeli($id_pegawai);
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

    public function cekOrderanPembayaranPembeli_get($id_pegawai)
    {
        $toko = $this->Pegawai_angkringan_model->result_orderan_pembayarn_pembeli($id_pegawai);
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
        $id_pegawai = $this->post('id_pegawai');
        $result_detail_transaksi = $this->Pegawai_angkringan_model->get_detail_transaksi2($no_order);
        foreach ($result_detail_transaksi as $key => $value) {
            $data_table_detail = array(
                'id_produk' => $value['id_produk'],
                'nilai_rating' => $ratingdetail,
                'komentar' => $komentar,
                'id_pegawai' => $id_pegawai,

            );
            $this->Pegawai_angkringan_model->tambah_ke_detail_rating_dan_komentar($data_table_detail);
        }
        $this->response([
            'status' => true,
            'message' => 'Found Your Keranjnag'
        ], RestController::HTTP_OK);
    }


    public function TambahMakanan_post()
    {
        $config['upload_path'] = './foto_produk/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_produk')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_produk' => $this->post('nama_produk'),
                'harga' => $this->post('harga'),
                'qty' => $this->post('qty'),
                'deskripsi' => $this->post('deskripsi'),
                'id_kategori' => $this->post('id_kategori'),
                'foto_produk' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->create_produk($upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }


    public function removeProduk_post($id_produk)
    {
        $this->Pegawai_angkringan_model->delete_produk($id_produk);
        $this->response([
            'status' => true,
            'message' => 'Produk Berhasil Di Delete'
        ], RestController::HTTP_OK);
    }


    public function uploadPotoPegawai_post()
    {
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'password' => password_hash($this->post('password'), PASSWORD_DEFAULT),
                'telepone' => $this->post('telepone'),
                'id_role' => 1,
                'file' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->create_pegawai($upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function ambil_pegawai_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_pegawai();
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

    public function hapusPegawai_post($id_pegawai)
    {
        $this->Pegawai_angkringan_model->delete_pegawai($id_pegawai);
        $this->response([
            'status' => true,
            'message' => 'Produk Berhasil Di Delete'
        ], RestController::HTTP_OK);
    }


    public function EditMakanan_post()
    {
        $config['upload_path'] = './foto_produk/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_produk')) {
            $fileData = $this->upload->data();
            $id_produk = $this->post('id_produk');
            $where = [
                'id_produk' => $id_produk
            ];
            $upload = [
                'nama_produk' => $this->post('nama_produk'),
                'harga' => $this->post('harga'),
                'qty' => $this->post('qty'),
                'deskripsi' => $this->post('deskripsi'),
                'id_kategori' => $this->post('id_kategori'),
                'foto_produk' => $fileData['file_name'],
            ];

            $this->Pegawai_angkringan_model->update_ke_produk($where, $upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function EditMakanansecond_post()
    {
        $id_produk = $this->post('id_produk');
        $where = [
            'id_produk' => $id_produk
        ];
        $datakirim = [
            'nama_produk' => $this->post('nama_produk'),
            'harga' => $this->post('harga'),
            'qty' => $this->post('qty'),
            'deskripsi' => $this->post('deskripsi'),
            'id_kategori' => $this->post('id_kategori'),

        ];
        $this->Pegawai_angkringan_model->update_ke_produk($where, $datakirim);
        $this->response([
            'status' => true,
            'data' => $datakirim,
            'message' => 'Success Register'
        ], RestController::HTTP_OK);
    }

    public function EditPegawai_post()
    {
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $id_pegawai = $this->post('id_pegawai');
            $where = [
                'id_pegawai' => $id_pegawai
            ];
            $upload = [
                'username' => $this->post('username'),
                'email' => $this->post('email'),
                'alamat' => $this->post('alamat'),
                'telepone' => $this->post('telepone'),
                'file' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->update_ke_pegawai($where, $upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function EditPegawaisecond_post()
    {
        $id_pegawai = $this->post('id_pegawai');
        $where = [
            'id_pegawai' => $id_pegawai
        ];
        $datakirim = [
            'username' => $this->post('username'),
            'email' => $this->post('email'),
            'alamat' => $this->post('alamat'),
            'telepone' => $this->post('telepone'),
        ];
        $this->Pegawai_angkringan_model->update_ke_pegawai($where, $datakirim);
        $this->response([
            'status' => true,
            'data' => $datakirim,
            'message' => 'Success Register'
        ], RestController::HTTP_OK);
    }


    public function ambil_pegawairow_get($id_pegawai)
    {
        $toko = $this->Pegawai_angkringan_model->get_row_pegawai($id_pegawai);
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


    // APLIKASI SAMSUDIN NASDEM
    public function uploadWarga_post()
    {
        $config['upload_path'] = './foto_kk/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_kepala_warga' => $this->post('nama_kepala_warga'),
                'telepone' => $this->post('telepone'),
                'alamat' => $this->post('alamat'),
                'jumlah_pemilih' => $this->post('jumlah_pemilih'),
                'id_pegawai' => $this->post('id_pegawai'),
                'kelurahan' => $this->post('kelurahan'),
                'rt' => $this->post('rt'),
                'rw' => $this->post('rw'),
                'file' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->create_warga($upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function get_role_3_get()
    {
        $role3 = $this->Pegawai_angkringan_model->get_role3();
        if ($role3) {
            $this->response([
                'status' => true,
                'data' => $role3,
                'message' => 'Found Your Data'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA DATA'
            ], RestController::HTTP_NOT_FOUND);
        }
    }


    public function ambil_warga_get()
    {
        $toko = $this->Pegawai_angkringan_model->result_warga();
        $total_warga = $this->Pegawai_angkringan_model->count_warga();

        if ($toko) {
            $this->response([
                'status' => true,
                'data' => $toko,
                'total_warga' => $total_warga,
                'message' => 'Found Your Produk'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'MAAF BELUM ADA PRODUK'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function EditWarga_post()
    {
        $config['upload_path'] = './foto_kk/';
        $config['allowed_types'] = 'jpeg|jpg|png|mp4';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $id_warga = $this->post('id_warga');
            $where = [
                'id_warga' => $id_warga
            ];
            $upload = [
                'nama_kepala_warga' => $this->post('nama_kepala_warga'),
                'telepone' => $this->post('telepone'),
                'alamat' => $this->post('alamat'),
                'jumlah_pemilih' => $this->post('jumlah_pemilih'),
                'id_pegawai' => $this->post('id_pegawai'),
                'file' => $fileData['file_name'],
            ];
            $this->Pegawai_angkringan_model->update_ke_warga($where, $upload);
            $this->response([
                'status' => true,
                'data' => $fileData['file_name'],
                'message' => 'Success Register'
            ], RestController::HTTP_OK);
        }
    }

    public function EditWargasecond_post()
    {
        $id_warga = $this->post('id_warga');
        $where = [
            'id_warga' => $id_warga
        ];
        $datakirim = [
            'nama_kepala_warga' => $this->post('nama_kepala_warga'),
            'telepone' => $this->post('telepone'),
            'alamat' => $this->post('alamat'),
            'jumlah_pemilih' => $this->post('jumlah_pemilih'),
            'id_pegawai' => $this->post('id_pegawai'),
        ];
        $this->Pegawai_angkringan_model->update_ke_warga($where, $datakirim);
        $this->response([
            'status' => true,
            'data' => $datakirim,
            'message' => 'Success Register'
        ], RestController::HTTP_OK);
    }

    public function hapusWarga_post($id_warga)
    {
        $this->Pegawai_angkringan_model->delete_warga($id_warga);
        $this->response([
            'status' => true,
            'message' => 'Warga Berhasil Di Delete'
        ], RestController::HTTP_OK);
    }

    public function data_warga_get($id_pegawai)
    {
        $id_role = $this->Pegawai_angkringan_model->get_pegawai($id_pegawai);
        if ($id_role['id_role'] == 1) {
            $warga = $this->Pegawai_angkringan_model->get_timses_pegawai();

            if ($warga) {
                $this->response([
                    'status' => true,
                    'data' => $warga,
                    'message' => 'Found Your Data'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'MAAF BELUM ADA Data'
                ], RestController::HTTP_NOT_FOUND);
            }
        } else if ($id_role['id_role'] == 3) {
            $warga = $this->Pegawai_angkringan_model->get_warga_pegawai($id_pegawai);
            if ($warga) {
                $this->response([
                    'status' => true,
                    'data' => $warga,
                    'message' => 'Found Your Data'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'MAAF BELUM ADA Data'
                ], RestController::HTTP_NOT_FOUND);
            }
        }
    }

    // 

    function Kirim_pesananku_post()
    {
        $table = "angkringan_transaksi";
        $field = "no_order";
        $array_bulan = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $bulan = $array_bulan[date('n')];
        $tahun = date('Y');
        $text =  $tahun . '.' . $bulan . '.ICOST.PS.';
        $kode_terakhirnya = $this->Pegawai_angkringan_model->get_kode_po($text, $table, $field);
        $no_urut = (int) substr($kode_terakhirnya, -4, 4);
        $no_urut++;
        $no_order = $text . sprintf('%04s', $no_urut);
        // INI UNTUK  BAGIAN POSTNYA UPDATE KE TBL_TRANSAKSI_PO
        // $id_pegawai =  60;
        // $metode_pembayaran =  'cash';
        // $total_pesanan =  20000;
        // $no_bangku =  'asasdasd';
        $id_pegawai =  $this->post('id_pegawai');
        $metode_pembayaran =  $this->post('metode_pembayaran');
        $total_pesanan =  $this->post('total_pesanan');
        $no_bangku =  $this->post('no_bangku');
        $row_pegawai = $this->Pegawai_angkringan_model->get_pegawai($id_pegawai);
        $result_keranjang = $this->Pegawai_angkringan_model->cek_keranjnag_saya($id_pegawai);
        $items = array();
        foreach ($result_keranjang as $key => $value) {
            $items = array(
                'name' => $value['nama_produk'],
                'quantity' => $value['jumlah_pesanan'],
                'price' => $value['harga'],
                'url' => 'https=>//yourcompany.com/example_item'
            );
        }
        Xendit::setApiKey('xnd_development_k5NhSKGE5HMGpywJP7TzloUuEVPxBYdjcRWtJSWs3fTcyJgExLhmg2XUjrxJy8T');
        $params = [
            'external_id' => $no_order,
            'amount' => $total_pesanan,
            'description' => $no_bangku,
            'invoice_duration' => 86400,
            'customer' => [
                'given_names' => $row_pegawai['username'],
                'email' => $row_pegawai['email'],
                'mobile_number' => $row_pegawai['telepone'],
                'addresses' => [
                    [
                        'city' => $row_pegawai['alamat'],
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
            'success_redirect_url' => 'https=>//www.google.com',
            'failure_redirect_url' => 'https=>//www.google.com',
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
        $upload = [
            'no_order' => $no_order,
            'id_pegawai' => $id_pegawai,
            'status_pesanan' => 1,
            'total_pesanan' => $total_pesanan,
            'metode_pembayaran' => $metode_pembayaran,
            'no_bangku' => $no_bangku,
        ];
        $this->Pegawai_angkringan_model->tambah_ke_angkringan_transaksi($upload);
        $result_keranjang = $this->Pegawai_angkringan_model->cek_keranjnag_saya($id_pegawai);
        foreach ($result_keranjang as $key => $value) {
            $data_table_detail = array(
                'no_order' => $no_order,
                'id_produk' => $value['id_produk'],
                'jumlah_pesanan' => $value['jumlah_pesanan'],
            );
            $this->Pegawai_angkringan_model->tambah_ke_angkringan_detail_transaksi($data_table_detail);
        }
        $this->db->delete('angkringan_keranjang', ['id_pegawai' => $id_pegawai]);
        return $this->db->affected_rows();
        $this->response([
            'status' => true,
            'message' => 'Berhasil Melakukan Pemesanan'
        ], RestController::HTTP_OK);
    }
}
