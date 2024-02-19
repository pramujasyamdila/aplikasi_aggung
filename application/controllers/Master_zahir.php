<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Master_zahir extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Paket/Paket_model');
        $this->load->model('Global_zahir/Global_zahir_model');
        $this->load->model('Auth_model');
        $this->load->library(array('form_validation', 'recaptcha'));
    }

    function user()
    {
        $data['title'] = 'Produk';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
        $this->load->view('pegawai/ajax');
    }



    function gagal_pesanan()
    {
        $this->load->view('failed_order');
    }
    function success_pesanan()
    {
        $this->load->view('success_order');
    }
    function SuksessBayar()
    {
        $data['title'] = 'Pembayaran';
        $this->load->view('pembayaran/success', $data);
    }

    function edit_hotel($id_user)
    {
        $data['title'] = 'Edit Hotel';
        $data['row_user'] = $this->Global_zahir_model->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('pegawai/ajax');
    }
    public function get_table_user()
    {
        $resultss = $this->Global_zahir_model->get_table_user();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_user;
            $row[] =  $angga->telepone;
            $row[] =  $angga->email;
            $row[] =  $angga->alamat;
            if ($angga->status == 1) {
                $row[] = '<small class="badge badge-success"> Aktive</small>';
            } else {
                $row[] = '<small class="badge badge-danger"> Non Active</small>';
            }
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_user . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_user . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_zahir_model->count_all_data_user(),
            "recordsFiltered" => $this->Global_zahir_model->count_filtered_data_user(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_user($id_user)
    {

        $get_user = $this->Global_zahir_model->by_id_user($id_user);
        $output = [
            "get_user" => $get_user,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_riwayat_taggihan_bulanan($id_riwayat_pemabayaran)
    {

        $get_riwayat_taggihan_bulanan = $this->Global_zahir_model->by_id_riwayat_pemabayaran($id_riwayat_pemabayaran);
        $output = [
            "get_riwayat_taggihan_bulanan" => $get_riwayat_taggihan_bulanan,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function tambah_hotel()
    {
        $nama_user = $this->input->post('nama_user');
        $telepone = $this->input->post('telepone');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $data = [
            'nama_user' => $nama_user,
            'telepone' => $telepone,
            'email' => $email,
            'alamat' => $alamat,
            'username' => $username,
            'status' => $status,
            'id_role' => 1,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $this->Global_zahir_model->add_user($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }




    public function hapus_hotel($id_user)
    {
        $this->Global_zahir_model->delete_user($id_user);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_hotel_post()
    {
        $where = [
            'id_user' => $this->input->post('id_user')
        ];

        $nama_user = $this->input->post('nama_user');
        $telepone = $this->input->post('telepone');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $data = [
            'nama_user' => $nama_user,
            'telepone' => $telepone,
            'email' => $email,
            'alamat' => $alamat,
            'username' => $username,
            'status' => $status,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'id_role' => 1,
        ];
        $this->Global_zahir_model->update_user($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    // INI UNTUK NAMBAH DETAIL KAMAR PADA HOTEL
    function produk()
    {
        $data['title'] = 'Kamar';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('produk/index', $data);
        $this->load->view('template/footer');
        $this->load->view('produk/ajax');
    }


    function edit_produk_page($id_produk)
    {
        $data['title'] = 'Edit produk';
        $data['row_produk'] = $this->Global_zahir_model->by_id_produk($id_produk);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('produk/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('produk/ajax');
    }
    function pembayaran_cod($no_order)
    {
        $data['title'] = 'Pemabayaran Status';
        $data['row_detail_produk'] = $this->Global_zahir_model->by_row_produk_transaksi($no_order);
        $data['result_detail_produk'] = $this->Global_zahir_model->by_result_produk_transaksi($no_order);
        $this->load->view('template/header', $data);
        $this->load->view('produk/pembayaran_cod', $data);
        $this->load->view('template/footer');
    }

    function pembayaran_cod2($no_order)
    {
        $data['title'] = 'Pemabayaran Status';
        $data['row_detail_produk'] = $this->Global_zahir_model->by_row_produk_transaksi($no_order);
        $data['result_detail_produk'] = $this->Global_zahir_model->by_result_produk_transaksi($no_order);
        $this->load->view('template/header', $data);
        $this->load->view('produk/pembayaran_cod2', $data);
        $this->load->view('template/footer');
    }
    public function get_table_produk()
    {
        $resultss = $this->Global_zahir_model->get_table_produk();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  ' <a href="' . base_url('foto_produk/') . $angga->foto_produk . '"><img src="' . base_url('foto_produk/') . $angga->foto_produk . '" style="width:100px;" alt=""></a>';
            $row[] =  $angga->nama_produk;
            $row[] =  "Rp " . number_format($angga->harga_produk, 2, ',', '.');
            $row[] =  $angga->jenis_produk;
            $row[] =  $angga->ket_produk;
            $row[] =  $angga->qty_produk;
            $row[] = '<a href="javascript:;"  class="btn btn-block btn-sm btn-info" onClick="by_id(' . "'" . $angga->id_produk . "','gambar'" . ')"><i class="fas fa fa-eye"></i> Kelola Detail Gambar </a> <a href="javascript:;"  class="btn btn-block btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_produk . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-block btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_produk . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_zahir_model->count_all_data_produk(),
            "recordsFiltered" => $this->Global_zahir_model->count_filtered_data_produk(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function get_table_produk_gambar($id_produk)
    {
        $resultss = $this->Global_zahir_model->get_table_produk_gambar($id_produk);
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  ' <a href="' . base_url('foto_produk/') . $angga->foto_detail_produk . '"><img src="' . base_url('foto_produk/') . $angga->foto_detail_produk . '" style="width:100px;" alt=""></a>';
            $row[] = '<a href="javascript:;"  class="btn btn-block btn-sm btn-danger" onClick="by_id_produk_gambar(' . "'" . $angga->id_detail_gambar_produk . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_zahir_model->count_all_data_produk_gambar($id_produk),
            "recordsFiltered" => $this->Global_zahir_model->count_filtered_data_produk_gambar($id_produk),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_produk($id_produk)
    {

        $get_produk = $this->Global_zahir_model->by_id_produk($id_produk);
        $output = [
            "get_produk" => $get_produk,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_produk_gambar($id_detail_gambar_produk)
    {

        $get_produk_gambar = $this->Global_zahir_model->by_id_produk_gambar($id_detail_gambar_produk);
        $output = [
            "get_produk_gambar" => $get_produk_gambar,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function tambah_produk()
    {
        $nama_produk = $this->input->post('nama_produk');
        $jenis_produk = $this->input->post('jenis_produk');
        $harga_produk = $this->input->post('harga_produk');
        $ket_produk = $this->input->post('ket_produk');
        $harga_batas_penawaran_reseler = $this->input->post('harga_batas_penawaran_reseler');
        $qty_produk = $this->input->post('qty_produk');
        $config['upload_path'] = './foto_produk/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_produk')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_produk' => $nama_produk,
                'jenis_produk' => $jenis_produk,
                'harga_produk' => $harga_produk,
                'harga_batas_penawaran_reseler' => $harga_batas_penawaran_reseler,
                'ket_produk' => $ket_produk,
                'foto_produk' => $fileData['file_name'],
                'qty_produk' => $qty_produk,
            ];
            $this->Global_zahir_model->add_produk($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }
    public function tambah_produk_gambar()
    {
        $id_produk = $this->input->post('id_produk');
        $config['upload_path'] = './foto_produk/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_detail_produk')) {
            $fileData = $this->upload->data();
            $upload = [
                'id_produk' => $id_produk,
                'foto_detail_produk' => $fileData['file_name'],
            ];
            $this->Global_zahir_model->add_produk_gambar($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }



    public function hapus_produk($id_produk)
    {
        $this->Global_zahir_model->delete_produk($id_produk);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_produk_gambar($id_detail_gambar_produk)
    {
        $this->Global_zahir_model->delete_produk_gambar($id_detail_gambar_produk);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_produk()
    {

        $where = [
            'id_produk' => $this->input->post('id_produk')
        ];
        $nama_produk = $this->input->post('nama_produk');
        $jenis_produk = $this->input->post('jenis_produk');
        $harga_produk = $this->input->post('harga_produk');
        $ket_produk = $this->input->post('ket_produk');
        $harga_batas_penawaran_reseler = $this->input->post('harga_batas_penawaran_reseler');
        $qty_produk = $this->input->post('qty_produk');
        $config['upload_path'] = './foto_produk/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_produk')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_produk' => $nama_produk,
                'jenis_produk' => $jenis_produk,
                'harga_produk' => $harga_produk,
                'harga_batas_penawaran_reseler' => $harga_batas_penawaran_reseler,
                'ket_produk' => $ket_produk,
                'foto_produk' => $fileData['file_name'],
                'qty_produk' => $qty_produk,
            ];
            $this->Global_zahir_model->update_produk($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_produk' => $nama_produk,
                'jenis_produk' => $jenis_produk,
                'harga_produk' => $harga_produk,
                'harga_batas_penawaran_reseler' => $harga_batas_penawaran_reseler,
                'ket_produk' => $ket_produk,
                'qty_produk' => $qty_produk,
            ];
            $this->Global_zahir_model->update_produk($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    function PembayaranBerhasil()
    {
        // Mendapatkan semua header
        $headers = $this->input->request_headers();

        // Mendapatkan header khusus 'X-Callback-Key'
        $callbackKey = isset($headers['X-CALLBACK-TOKEN']) ? $headers['X-CALLBACK-TOKEN'] : '';

        // Verifikasi kunci callback
        // Ganti dengan kunci callback yang valid
        // $validKey = 'p8gjCrGZbiZnWdrwkSkrjTQqP71ZOsDYres45gYyaR40kemb';
        $validKey = 'A2WaWQUhAoChlwehTdsZkt4sVzrZGa2jSMLNoDYchzTDjrce';
        if ($callbackKey === $validKey) {
            // Proses callback invoice dari Xendit

            // Contoh pengolahan callback invoice
            $payload = file_get_contents('php://input');
            $data = json_decode($payload, true);
            $where = [
                'no_order' => $data['external_id']
            ];
            $datakirim = [
                'sts_pembayaran' => $data['status'],
                'tanggal_bayar' => $data['paid_at'],
            ];
            $this->Global_zahir_model->update_ke_transaksi($datakirim, $where);

            $no_order = $data['external_id'];
            $result_detail_transaksi = $this->Global_zahir_model->get_detail_transaksi($no_order);
            $row_transaksi = $this->Global_zahir_model->get_row_transaksi($no_order);
            foreach ($result_detail_transaksi as $key => $value) {
                $jumlah_pesanan = $value['jumlah_pesanan'];
                $id_produk = $value['id_produk'];
                $result_trx_produk = $this->Global_zahir_model->result_trx_produk($jumlah_pesanan, $id_produk);
                foreach ($result_trx_produk as $key => $value_trx) {
                    $data_insert_ke_produk_user = [
                        'id_user' => $row_transaksi['id_user'],
                        'no_order' => $no_order,
                        'id_produk' => $value_trx['id_produk'],
                        'nama_produk_detail' => $value_trx['nama_produk_detail'],
                        'harga_produk_detail' => $value_trx['harga_produk_detail'],
                        'kode_produk_detail' => $value_trx['kode_produk_detail'],
                        'jenis_produk_detail' => $value_trx['jenis_produk_detail'],
                        'sts_terjual' => $value_trx['sts_terjual'],
                        'username_produk' => $value_trx['username_produk'],
                        'password_produk' => $value_trx['password_produk'],
                    ];
                    $this->Global_zahir_model->insert_ke_produk_user($data_insert_ke_produk_user);
                }
                $data_update_trx_produk = [
                    'sts_terjual' => 1,
                ];
                $this->Global_zahir_model->update_ke_trx_produk($jumlah_pesanan, $id_produk, $data_update_trx_produk);
            }
            // Masukan Data Ke Bagian Konter

            // Lakukan apa pun yang perlu dilakukan dengan data callback invoice

            // Mengirimkan respons sukses ke Xendit
            http_response_code(200);
            echo 'Callback invoice berhasil diproses';
        } else {
            // Kunci callback tidak valid, tidak memproses callback invoice

            // Mengirimkan respons error ke Xendit
            http_response_code(401);
            echo 'Unauthorized';
        }
    }


    public function pembayaran_cod_view()
    {
        $data['title'] = 'PEMBAYARAN COD';
        $data['pembayaran'] = $this->Global_zahir_model->result_pembayaran();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('produk/pembayaran_cod_view', $data);
        $this->load->view('template/footer');
        $this->load->view('produk/ajax');
    }

    function approve_pembayaran($id_transaksi)
    {
        $where = [
            'id_transaksi' => $id_transaksi
        ];
        $datakirim = [
            'sts_pembayaran' => 'PAID',
            'tanggal_bayar' => date('Y-m-d H:i:s'),
        ];
        $this->Global_zahir_model->update_ke_transaksi($datakirim, $where);
        redirect('master/pembayaran_cod_view');
        die;
    }


    public function pencairan()
    {
        $data['title'] = 'PEMBAYARAN COD';
        $data['pembayaran'] = $this->Global_zahir_model->result_pembayaran();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('produk/pencairan', $data);
        $this->load->view('template/footer');
        $this->load->view('produk/ajax');
    }

    function pencairan_ke_bank($id_transaksi)
    {
        $row = $this->Global_zahir_model->row_pembayaran($id_transaksi);
        $where = [
            'id_transaksi' => $id_transaksi
        ];
        $datakirim = [
            'sts_pencairan' => 1,
            'tanggal_pencairan' => date('Y-m-d H:i:s'),
        ];
        $this->Global_zahir_model->update_ke_transaksi($datakirim, $where);
        $pesan = 'Anda Menerima Pencairan Dari No Order: ' . $row['no_order'] . ' Sejumlah ' . "Rp " . number_format($row['fee_reseller'], 2, ',', '.') . '';
        $this->notif_hp->notif_hp($row['id_user'], $pesan);
        redirect('master/pencairan');
        die;
    }
}
