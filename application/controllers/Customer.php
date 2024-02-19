<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Paket/Paket_model');
        $this->load->model('Global/Global_model');
        $this->load->model('Auth_model');
        $this->load->library(array('form_validation', 'recaptcha'));
    }
    function pegawai()
    {
        $data['title'] = 'Pegawai';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
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

    function edit_pegawai($id_user)
    {
        $data['title'] = 'Edit Pegawai';
        $data['row_user'] = $this->Global_model->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('pegawai/ajax');
    }
    public function get_table_user()
    {
        $resultss = $this->Global_model->get_table_user();
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
            "recordsTotal" => $this->Global_model->count_all_data_user(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_user($id_user)
    {

        $get_user = $this->Global_model->by_id_user($id_user);
        $output = [
            "get_user" => $get_user,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_riwayat_taggihan_bulanan($id_riwayat_pemabayaran)
    {

        $get_riwayat_taggihan_bulanan = $this->Global_model->by_id_riwayat_pemabayaran($id_riwayat_pemabayaran);
        $output = [
            "get_riwayat_taggihan_bulanan" => $get_riwayat_taggihan_bulanan,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function tambah_user()
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
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $this->Global_model->add_user($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_user($id_user)
    {
        $this->Global_model->delete_user($id_user);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_user()
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
        $this->Global_model->update_user($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }


    function iklan()
    {
        $data['title'] = 'Iklan';
        $data['result_voucher'] = $this->Global_model->result_voucher();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('iklan/index', $data);
        $this->load->view('template/footer');
        $this->load->view('iklan/ajax');
    }

    function edit_iklan_page($id_iklan)
    {
        $data['title'] = 'Edit Iklan';
        $data['row_iklan'] = $this->Global_model->by_id_iklan($id_iklan);
        $data['result_voucher'] = $this->Global_model->result_voucher();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('iklan/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('iklan/ajax');
    }
    public function get_table_iklan()
    {
        $resultss = $this->Global_model->get_table_iklan();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_iklan;
            $row[] =  $angga->nama_voucher;
            $row[] =  $angga->deskripsi_iklan;
            $row[] =  ' <a href="' . base_url('foto_iklan/') . $angga->foto_iklan . '"><img src="' . base_url('foto_iklan/') . $angga->foto_iklan . '" style="width:100px;" alt=""></a>';
            if ($angga->status_iklan == 1) {
                $row[] = '<small class="badge badge-success"> Aktive</small>';
            } else {
                $row[] = '<small class="badge badge-danger"> Non Active</small>';
            }
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_iklan . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_iklan . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_iklan(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_iklan(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_iklan($id_iklan)
    {

        $get_iklan = $this->Global_model->by_id_iklan($id_iklan);
        $output = [
            "get_iklan" => $get_iklan,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function tambah_iklan()
    {
        $nama_iklan = $this->input->post('nama_iklan');
        $jenis_iklan = $this->input->post('jenis_iklan');
        $id_voucher = $this->input->post('id_voucher');
        $row_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $deskripsi_iklan = $this->input->post('deskripsi_iklan');
        $status = $this->input->post('status_iklan');
        $config['upload_path'] = './foto_iklan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_iklan')) {
            $fileData = $this->upload->data();
            $upload = [
                'id_voucher' => $id_voucher,
                'nama_iklan' => $nama_iklan,
                'deskripsi_iklan' => $deskripsi_iklan,
                'status_iklan' => $status,
                'harga_iklan' => $row_voucher['harga_voucher'],
                'foto_iklan' => $fileData['file_name'],
                'jenis_iklan' => $jenis_iklan,
            ];
            $this->Global_model->add_iklan($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }

    public function hapus_iklan($id_iklan)
    {
        $this->Global_model->delete_iklan($id_iklan);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function edit_iklan()
    {
        $where = [
            'id_iklan' => $this->input->post('id_iklan')
        ];

        $nama_iklan = $this->input->post('nama_iklan');
        $jenis_iklan = $this->input->post('jenis_iklan');
        $id_voucher = $this->input->post('id_voucher');
        $row_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $deskripsi_iklan = $this->input->post('deskripsi_iklan');
        $status = $this->input->post('status_iklan');
        $config['upload_path'] = './foto_iklan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_iklan')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_iklan' => $nama_iklan,
                'harga_iklan' => $row_voucher['harga_voucher'],
                'deskripsi_iklan' => $deskripsi_iklan,
                'status_iklan' => $status,
                'id_voucher' => $id_voucher,
                'foto_iklan' => $fileData['file_name'],
                'jenis_iklan' => $jenis_iklan,
            ];
            $this->Global_model->update_iklan($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'id_voucher' => $id_voucher,
                'harga_iklan' => $row_voucher['harga_voucher'],
                'nama_iklan' => $nama_iklan,
                'deskripsi_iklan' => $deskripsi_iklan,
                'status_iklan' => $status,
            ];
            $this->Global_model->update_iklan($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    function konter()
    {
        $data['title'] = 'Dashboard';
        $data['result_lokasi'] = $this->Global_model->result_lokasi();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('konter/index', $data);
        $this->load->view('template/footer');
        $this->load->view('konter/ajax');
    }
    function edit_konter_page($id_user)
    {
        $data['title'] = 'Edit Konter';
        $data['row_user'] = $this->Global_model->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('konter/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('konter/ajax');
    }

    public function get_table_user_konter()
    {
        $resultss = $this->Global_model->get_table_user_konter();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_user;
            $row[] =  $angga->telepone;
            $row[] =  $angga->kode_referal;
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
            "recordsTotal" => $this->Global_model->count_all_data_user(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_konter()
    {
        $nama_user = $this->input->post('nama_user');
        $id_lokasi = $this->input->post('id_lokasi');
        $telepone = $this->input->post('telepone');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $status = $this->input->post('status');
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_user' => $nama_user,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'username' => $username,
                'id_lokasi' => $id_lokasi,
                'kode_referal' => 'ICST.' . random_string('numeric', 6),
                'status' => $status,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'file' => $fileData['file_name'],
                'id_role' => 2
            ];
            $this->Global_model->add_user($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_user' => $nama_user,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'id_lokasi' => $id_lokasi,
                'username' => $username,
                'status' => $status,
                'kode_referal' => 'ICST.' . random_string('numeric', 6),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id_role' => 2
            ];
            $this->Global_model->add_user($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    public function edit_konter()
    {
        $where = [
            'id_user' => $this->input->post('id_user')
        ];
        $nama_user = $this->input->post('nama_user');
        $id_lokasi = $this->input->post('id_lokasi');
        $telepone = $this->input->post('telepone');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $status = $this->input->post('status');
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_user' => $nama_user,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'id_lokasi' => $id_lokasi,
                'username' => $username,
                'status' => $status,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'file' => $fileData['file_name'],
                'id_role' => 2
            ];
            $this->Global_model->update_user($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_user' => $nama_user,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'id_lokasi' => $id_lokasi,
                'username' => $username,
                'status' => $status,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id_role' => 2
            ];
            $this->Global_model->update_user($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    function umum()
    {
        $data['title'] = 'CUSTOMER UMUM';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/index', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax');
    }
    //menu customer bulanan
    function bulanan()
    {
        $data['result_lokasi'] = $this->Global_model->result_lokasi();
        $data['result_paket_pilihan_bulanan'] = $this->Global_model->result_paket_pilihan_bulanan();
        $data['title'] = 'Pelanggan Bulanan';

        //get jumlah data tabel user
        $data['jml_aktif'] = $this->Global_model->get_pelanggan_aktif();
        //get jumlah data tabel user non aktif
        $data['jml_non'] = $this->Global_model->get_pelanggan_non();
        //get semua data pelanggan bulanan
        $data['jml_all'] = $this->Global_model->get_pelanggan_semua();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/bulanan', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax_bulanan');
    }

    function bulanan_pendaftar()
    {
        $data['result_lokasi'] = $this->Global_model->result_lokasi();
        $data['result_paket_pilihan_bulanan'] = $this->Global_model->result_paket_pilihan_bulanan();
        $data['title'] = 'Cek Signal Pelanggan Bulanan';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/bulanan_pendaftar', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax_bulanan');
    }

    public function tambah_pelanggan_bulanan()
    {
        $nama_user = $this->input->post('nama_user');
        $tipe_pembayaran_bulanan = $this->input->post('tipe_pembayaran_bulanan');
        $nama_sales = $this->input->post('nama_sales');
        $id_paket_bulanan_pilihan = $this->input->post('id_paket_bulanan_pilihan');
        $id_lokasi = $this->input->post('id_lokasi');
        $telepone = $this->input->post('telepone');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $status = $this->input->post('status');
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_user' => $nama_user,
                'tipe_pembayaran_bulanan' => $tipe_pembayaran_bulanan,
                'id_paket_bulanan_pilihan' => $id_paket_bulanan_pilihan,
                'nama_sales' => $nama_sales,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'username' => $username,
                'id_lokasi' => $id_lokasi,
                'kode_referal' => 'ICST.' . random_string('numeric', 6),
                'status' => $status,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'file' => $fileData['file_name'],
                'id_role' => 4
            ];
            $this->Global_model->add_user($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_user' => $nama_user,
                'tipe_pembayaran_bulanan' => $tipe_pembayaran_bulanan,
                'nama_sales' => $nama_sales,
                'id_paket_bulanan_pilihan' => $id_paket_bulanan_pilihan,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'id_lokasi' => $id_lokasi,
                'username' => $username,
                'status' => $status,
                'kode_referal' => 'ICST.' . random_string('numeric', 6),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id_role' => 4
            ];
            $this->Global_model->add_user($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    public function edit_pelanggan_bulanan()
    {
        $where = [
            'id_user' => $this->input->post('id_user')
        ];
        $nama_sales = $this->input->post('nama_sales');
        $id_paket_bulanan_pilihan = $this->input->post('id_paket_bulanan_pilihan');
        $tipe_pembayaran_bulanan = $this->input->post('tipe_pembayaran_bulanan');
        $nama_user = $this->input->post('nama_user');
        $id_lokasi = $this->input->post('id_lokasi');
        $telepone = $this->input->post('telepone');
        $email = $this->input->post('email');
        $alamat = $this->input->post('alamat');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $status = $this->input->post('status');
        $status = $this->input->post('status');
        $config['upload_path'] = './foto_user/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_user' => $nama_user,
                'tipe_pembayaran_bulanan' => $tipe_pembayaran_bulanan,
                'id_paket_bulanan_pilihan' => $id_paket_bulanan_pilihan,
                'nama_sales' => $nama_sales,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'id_lokasi' => $id_lokasi,
                'username' => $username,
                'status' => $status,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'file' => $fileData['file_name'],
                'id_role' => 4
            ];
            $this->Global_model->update_user($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_user' => $nama_user,
                'tipe_pembayaran_bulanan' => $tipe_pembayaran_bulanan,
                'id_paket_bulanan_pilihan' => $id_paket_bulanan_pilihan,
                'nama_sales' => $nama_sales,
                'telepone' => $telepone,
                'email' => $email,
                'alamat' => $alamat,
                'id_lokasi' => $id_lokasi,
                'username' => $username,
                'status' => $status,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'id_role' => 2
            ];
            $this->Global_model->update_user($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    public function get_table_umum()
    {
        $resultss = $this->Global_model->get_table_user_umum();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_user;
            $row[] =  $angga->telepone;
            $row[] =  $angga->email;
            $row[] =  $angga->alamat;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-info" onClick="by_id(' . "'" . $angga->id_user . "','edit'" . ')"><i class="fas fa fa-eye"></i> Detail </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_user_umum(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user_umum(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function get_table_bulanan()
    {
        $resultss = $this->Global_model->get_table_user_bulanan();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            if ($angga->status) {
                $row[] = '<label class="badge badge-danger"> Tidak Aktif</label>';
            } else {
                $row[] = '<label class="badge badge-success"> Aktif</label>';
            }
            $row[] =  $angga->nama_user;
            $row[] =  $angga->telepone;
            $row[] =  $angga->email;
            $row[] =  $angga->alamat;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-info" onClick="by_id(' . "'" . $angga->id_user . "','edit'" . ')"><i class="fas fa fa-eye"></i> Detail </a> <a href="javascript:;"  class="btn btn-sm btn-primary" onClick="by_id(' . "'" . $angga->id_user . "','view_formulir'" . ')"><i class="fas fa fa-file"></i> Formulir </a> <a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_user . "','riwayat_pembayaran'" . ')"><i class="fas fa fa-file"></i>Riwayat Pembayaran </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_user_bulanan(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user_bulanan(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }


    public function get_table_bulanan_langganan()
    {
        $resultss = $this->Global_model->get_table_user_bulanan_langganan();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_user;
            $row[] =  $angga->telepone;
            $row[] =  $angga->email;
            $row[] =  $angga->alamat;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_user . "','informasi_signal'" . ')"><i class="fas fa fa-file"></i>Kirim Informasi Signal </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_user_bulanan_langganan(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user_bulanan_langganan(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }


    public function get_table_riwayat_pembayaran_bulanan($id_user)
    {
        $resultss = $this->Global_model->get_table_user_riwayat_pembayaran_bulanan($id_user);
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->ket_pembayaran;
            $row[] =  $angga->jatoh_tempo;
            if ($angga->status_bayar == 1) {
                $row[] = '<small class="badge badge-success"> Sudah Bayar</small>';
            } else {
                $row[] = '<small class="badge badge-danger"> Belum Bayar</small>';
            }
            $row[] =  "Rp " . number_format($angga->total_pembayaran, 2, ',', '.');
            if ($angga->status_bayar == 1) {
                $row[] = '<a href="javascript:;"  class="btn btn-block btn-sm btn-danger" onClick="by_id_riwayat_taggihan_bulanan(' . "'" . $angga->id_riwayat_pemabayaran . "','view_dok_penaggihan'" . ')"><i class="fas fa fa-file"></i> Dok. Penaggihan </a>';
            } else {
                $row[] = '<a href="javascript:;"  class="btn btn-block btn-sm btn-warning" onClick="by_id_riwayat_taggihan_bulanan(' . "'" . $angga->id_riwayat_pemabayaran . "','kirim_taggihan'" . ')"><i class="fas fa fa-file"></i> Kirim Taggihan </a> <a href="javascript:;"  class="btn btn-block btn-sm btn-success" onClick="by_id_riwayat_taggihan_bulanan(' . "'" . $angga->id_riwayat_pemabayaran . "','cek_pembayaran'" . ')"><i class="fas fa fa-file"></i> Cek Pembayaran </a> <a href="javascript:;"  class="btn btn-block btn-sm btn-danger" onClick="by_id_riwayat_taggihan_bulanan(' . "'" . $angga->id_riwayat_pemabayaran . "','view_dok_penaggihan'" . ')"><i class="fas fa fa-file"></i> Dok. Penaggihan </a>';
            }

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_user_riwayat_pembayaran_bulanan($id_user),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user_riwayat_pembayaran_bulanan($id_user),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }


    function generate_taggihan_pelanggan_bulanan($id_user)
    {
        $cek_pembayaran_register = $this->Global_model->cek_pembayaran_registrasi($id_user);
        $row_user = $this->Global_model->by_id_user($id_user);
        $cek_pembayaran_bulanan = $this->Global_model->cek_pembayaran_bulanan($id_user);
        if ($cek_pembayaran_register) {
        } else {
            $biaya_aktivasi = 200000;
            $data = [
                'id_user' => $id_user,
                'tanggal_bayar' => date('Y-m-d'),
                'jatoh_tempo' =>  date("Y-m-d"),
                'jenis_pembayaran' => $row_user['tipe_pembayaran_bulanan'],
                'jenis_taggihan' => 'Pembayaran Registrasi',
                'ket_pembayaran' => 'Pembayaran Registasi Dan Instalasi',
                'total_pembayaran' => $biaya_aktivasi,
            ];
            $this->Global_model->insert_generate_taggihan_bulanan($data);
        }
        if ($cek_pembayaran_bulanan) {
        } else {
            $total_paket_terpilih = $row_user['harga_paket_bulanan'];
            $total_harus_dibayar = $total_paket_terpilih;
            $data2 = [
                'id_user' => $id_user,
                'tanggal_bayar' => date('Y-m-d'),
                'jatoh_tempo' =>  date("Y-m-d", strtotime("+1 month")),
                'jenis_pembayaran' => $row_user['tipe_pembayaran_bulanan'],
                'jenis_taggihan' => 'Pembayaran Bulanan',
                'ket_pembayaran' => 'Pembayaran Bulanan ' . $row_user['nama_paket_bulanan'],
                'total_pembayaran' => $total_harus_dibayar,
            ];
            $this->Global_model->insert_generate_taggihan_bulanan($data2);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    function update_pemabayaran_bulanan($id_riwayat_pemabayaran)
    {
        $where = [
            'id_riwayat_pemabayaran' => $id_riwayat_pemabayaran
        ];
        $data = [
            'status_bayar' => 1,
        ];
        $this->Global_model->update_tbl_riwayat_pembayaran_bulanan($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }


    function kirim_informasi_signal()
    {
        $id_user = $this->input->post('id_user');
        $informasi_signal = $this->input->post('informasi_signal');
        $row_user = $this->Global_model->by_id_user($id_user);
        $type = 'daftar_baru';
        $message = 'Hallo ' . $row_user['username'] . ' ' . $informasi_signal . '';
        $this->kirim_wa->kirim_wa($type, $row_user['telepone'], $message);
        $where = [
            'id_user' => $id_user,
        ];
        $data = [
            'status_berlangganan' => NULL,
        ];
        $this->Global_model->update_user($data, $where);
        $data_notif = [
            'id_user' => $id_user,
            'message' => $message
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($data_notif));
    }

    function kirim_informasi()
    {
        $id_user = $this->input->post('id_user');
        $informasi_signal = $this->input->post('informasi_signal');
        $row_user = $this->Global_model->by_id_user($id_user);
        $type = 'daftar_baru';
        $message = 'Hallo ' . $row_user['username'] . ' ' . $informasi_signal . '';
        $this->kirim_wa->kirim_wa($type, $row_user['telepone'], $message);
        $where = [
            'id_user' => $id_user,
        ];
        $data = [
            'status_berlangganan' => 1,
        ];
        $this->Global_model->update_user($data, $where);
        $data_notif = [
            'id_user' => $id_user,
            'message' => $message
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($data_notif));
    }



    function riwayat_pembayaran($id_user)
    {
        $data['row_user'] = $this->Global_model->by_id_user($id_user);
        $data['result_lokasi'] = $this->Global_model->result_lokasi();
        $data['result_paket_pilihan_bulanan'] = $this->Global_model->result_paket_pilihan_bulanan();
        $data['title'] = 'Riwayat Pembayaran';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/riwayat_pembayaran_bulanan', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax_bulanan');
    }
    function view_dok_penaggihan($id_user)
    {
        $data['title'] = 'Dokumen Penaggihan';
        $data['row_user'] = $this->Global_model->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/view_dok_penaggihan', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax');
    }

    function view_vormulir_pendaftaran_bulanan($id_user)
    {
        $data['title'] = 'Formulir Pendaftaran';
        $data['row_user'] = $this->Global_model->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/view_formulir_pendaftaran', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax');
    }

    function edit_umum_page($id_user)
    {
        $data['title'] = 'Detail Customer Umum';
        $data['row_user'] = $this->Global_model->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('umum/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('umum/ajax');
    }

    function voucher()
    {
        $data['title'] = 'VOUCER';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/index', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax');
    }


    function edit_voucher_page($id_voucher)
    {
        $data['title'] = 'Edit Voucher';
        $data['row_voucher'] = $this->Global_model->by_id_voucher($id_voucher);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax');
    }

    function edit_voucher_page_mitra($id_voucher)
    {
        $data['title'] = 'Edit Voucher Mitra';
        $data['row_voucher'] = $this->Global_model->by_id_voucher($id_voucher);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/edit_mitra', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax_mitra');
    }


    function master_detail_voucher_page($id_voucher)
    {
        $data['title'] = 'Buat Detail Voucher';
        $data['row_voucher'] = $this->Global_model->by_id_voucher($id_voucher);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/master_detail_voucher', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax', $data);
    }

    function master_detail_voucher_page_mitra($id_voucher)
    {
        $data['title'] = 'Buat Detail Voucher Mitra/Konter';
        $data['row_voucher'] = $this->Global_model->by_id_voucher($id_voucher);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/master_detail_voucher_mitra', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax_mitra', $data);
    }


    function import_voucher()
    {
        $data['title'] = 'IMPORT VOUCHER';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/import', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax');
    }



    public function get_table_voucher()
    {
        $resultss = $this->Global_model->get_table_voucher();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $count_voucher_detail = $this->Global_model->count_voucher($angga->id_voucher);
            $row = array();
            $row[] = ++$no;
            $row[] =  ' <a href="' . base_url('foto_iklan/') . $angga->foto_voucher . '"><img src="' . base_url('foto_iklan/') . $angga->foto_voucher . '" style="width:100px;" alt=""></a>';
            $row[] =  $angga->nama_voucher;
            $row[] =  $angga->jenis_voucher;
            $row[] =  "Rp " . number_format($angga->harga_voucher, 2, ',', '.');
            $row[] =  $count_voucher_detail;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-info" onClick="by_id(' . "'" . $angga->id_voucher . "','detail'" . ')"><i class="fas fa fa-eye"></i> Buat Detail Voucher </a> <a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_voucher . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_voucher . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_voucher(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_voucher(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_voucher($id_voucher)
    {

        $get_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $output = [
            "get_voucher" => $get_voucher,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function tambah_voucher()
    {
        $nama_voucher = $this->input->post('nama_voucher');
        $jenis_voucher = $this->input->post('jenis_voucher');
        $harga_voucher = $this->input->post('harga_voucher');
        $config['upload_path'] = './foto_iklan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_voucher')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_voucher' => $nama_voucher,
                'jenis_voucher' => $jenis_voucher,
                'harga_voucher' => $harga_voucher,
                'harga_jual' => $harga_voucher,
                'ket_voucher' => 'umum',
                'foto_voucher' => $fileData['file_name'],
            ];
            $this->Global_model->add_voucher($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }

    public function tambah_voucher_mitra()
    {
        $nama_voucher = $this->input->post('nama_voucher');
        $id_user = $this->input->post('id_user');
        $jenis_voucher = $this->input->post('jenis_voucher');
        $harga_voucher = $this->input->post('harga_voucher');
        $harga_jual = $this->input->post('harga_jual');
        $config['upload_path'] = './foto_iklan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_voucher')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_voucher' => $nama_voucher,
                'id_user' => $id_user,
                'jenis_voucher' => $jenis_voucher,
                'harga_voucher' => $harga_voucher,
                'harga_jual' => $harga_jual,
                'ket_voucher' => 'konter',
                'foto_voucher' => $fileData['file_name'],
            ];
            $this->Global_model->add_voucher($upload);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }


    public function hapus_voucher($id_voucher)
    {
        $this->Global_model->delete_voucher($id_voucher);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_voucher()
    {

        $where = [
            'id_voucher' => $this->input->post('id_voucher')
        ];
        $nama_voucher = $this->input->post('nama_voucher');
        $jenis_voucher = $this->input->post('jenis_voucher');
        $harga_voucher = $this->input->post('harga_voucher');
        $config['upload_path'] = './foto_iklan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_voucher')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_voucher' => $nama_voucher,
                'jenis_voucher' => $jenis_voucher,
                'harga_voucher' => $harga_voucher,
                'harga_jual' => $harga_voucher,
                'foto_voucher' => $fileData['file_name'],
            ];
            $this->Global_model->update_voucher($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_voucher' => $nama_voucher,
                'jenis_voucher' => $jenis_voucher,
                'harga_voucher' => $harga_voucher,
                'harga_jual' => $harga_voucher,
            ];
            $this->Global_model->update_voucher($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    public function edit_voucher_mitra()
    {

        $where = [
            'id_voucher' => $this->input->post('id_voucher')
        ];
        $nama_voucher = $this->input->post('nama_voucher');
        $jenis_voucher = $this->input->post('jenis_voucher');
        $harga_voucher = $this->input->post('harga_voucher');
        $harga_jual = $this->input->post('harga_jual');
        $config['upload_path'] = './foto_iklan/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_voucher')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_voucher' => $nama_voucher,
                'harga_jual' => $harga_jual,
                'jenis_voucher' => $jenis_voucher,
                'harga_voucher' => $harga_voucher,
                'foto_voucher' => $fileData['file_name'],
            ];
            $this->Global_model->update_voucher($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        } else {
            $upload = [
                'nama_voucher' => $nama_voucher,
                'harga_jual' => $harga_jual,
                'jenis_voucher' => $jenis_voucher,
                'harga_voucher' => $harga_voucher,
            ];
            $this->Global_model->update_voucher($upload, $where);
            $this->output->set_content_type('application/json')->set_output(json_encode('success'));
        }
    }

    public function import_voucher_excel()
    {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = 'doc' . time();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('importexcel')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open('uploads/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 0;
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 0) {
                        $data = array(
                            'nama_voucher' => $row->getCellAtIndex(0),
                            'kode_voucher' => $row->getCellAtIndex(1),
                            'jenis_voucher' => $row->getCellAtIndex(2),
                            'harga_voucher' => $row->getCellAtIndex(3),

                        );
                        $this->Global_model->insert_voucher($data);
                    }
                    $numRow++;
                }
                $reader->close();
                unlink('uploads/' . $file['file_name']);
                $this->session->set_flashdata('pesan', 'Data Berhasil Di Import');
                redirect('customer/voucher');
            }
        } else {
            echo "Error : " . $this->upload->display_errors();
        }
    }
    function import_detail_voucher($id_voucher)
    {
        $data['row_voucher'] = $this->Global_model->by_id_voucher($id_voucher);
        $data['title'] = 'IMPORT VOUCHER';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/import_detail_voucher', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax');
    }

    function import_detail_voucher_mitra($id_voucher)
    {
        $data['row_voucher'] = $this->Global_model->by_id_voucher($id_voucher);
        $data['title'] = 'IMPORT VOUCHER';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/import_detail_voucher_mitra', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax_mitra');
    }

    public function import_detail_voucher_excel($id_voucher)
    {
        $row_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = 'doc' . time();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('importexcel')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open('uploads/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 0;
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 0) {
                        $data = array(
                            'id_voucher' => $row_voucher['id_voucher'],
                            'nama_voucher_detail' => $row_voucher['nama_voucher'],
                            'harga_voucher_detail' => $row_voucher['harga_voucher'],
                            'harga_jual_voucher_detail' => $row_voucher['harga_voucher'],
                            'jenis_voucher_detail' => $row_voucher['jenis_voucher'],
                            'kode_voucher_detail' => $row->getCellAtIndex(0),
                            'username_voucher' => $row->getCellAtIndex(0),
                            'password_voucher' => $row->getCellAtIndex(1),

                        );
                        $this->Global_model->insert_detail_voucher($data);
                    }
                    $numRow++;
                }
                $reader->close();
                unlink('uploads/' . $file['file_name']);
            }
            // update voucher 
            $count_voucher = $this->Global_model->count_voucher($id_voucher);
            $where = [
                'id_voucher' => $id_voucher
            ];
            $data = [
                'qty_voucher' => $count_voucher,
            ];
            $this->Global_model->update_voucher($data, $where);
            $this->session->set_flashdata('pesan', 'Data Berhasil Di Import');
            redirect(base_url('customer/master_detail_voucher_page/' . $row_voucher['id_voucher']));
        } else {
            echo "Error : " . $this->upload->display_errors();
        }
    }

    public function import_detail_voucher_excel_mitra($id_voucher)
    {
        $row_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'xlsx|xls';
        $config['file_name'] = 'doc' . time();
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('importexcel')) {
            $file = $this->upload->data();
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open('uploads/' . $file['file_name']);
            foreach ($reader->getSheetIterator() as $sheet) {
                $numRow = 0;
                foreach ($sheet->getRowIterator() as $row) {
                    if ($numRow > 0) {
                        $data = array(
                            'id_voucher' => $row_voucher['id_voucher'],
                            'nama_voucher_detail' => $row_voucher['nama_voucher'],
                            'harga_voucher_detail' => $row_voucher['harga_voucher'],
                            'harga_jual_voucher_detail' => $row_voucher['harga_jual'],
                            'jenis_voucher_detail' => $row_voucher['jenis_voucher'],
                            'kode_voucher_detail' => $row->getCellAtIndex(0),
                            'username_voucher' => $row->getCellAtIndex(0),
                            'password_voucher' => $row->getCellAtIndex(1),

                        );
                        $this->Global_model->insert_detail_voucher($data);
                    }
                    $numRow++;
                }
                $reader->close();
                unlink('uploads/' . $file['file_name']);
            }
            // update voucher 
            $count_voucher = $this->Global_model->count_voucher($id_voucher);
            $where = [
                'id_voucher' => $id_voucher
            ];
            $data = [
                'qty_voucher' => $count_voucher,
            ];
            $this->Global_model->update_voucher($data, $where);
            $this->session->set_flashdata('pesan', 'Data Berhasil Di Import');
            redirect(base_url('customer/master_detail_voucher_page_mitra/' . $row_voucher['id_voucher']));
        } else {
            echo "Error : " . $this->upload->display_errors();
        }
    }
    public function get_table_detail_voucher($id_voucher)
    {
        $resultss = $this->Global_model->get_table_detail_voucher($id_voucher);
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_voucher_detail;
            $row[] =  "Rp " . number_format($angga->harga_voucher_detail);
            $row[] =  $angga->kode_voucher_detail;
            $row[] =  $angga->jenis_voucher_detail;
            if ($angga->sts_terjual == 1) {
                $row[] = '<small class="badge badge-success"> Terjual</small>';
            } else {
                $row[] = '<small class="badge badge-danger"> Belum Terjual</small>';
            }

            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id_detail_voucher(' . "'" . $angga->id_detail_voucher . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_detail_voucher($id_voucher),
            "recordsFiltered" => $this->Global_model->count_filtered_data_detail_voucher($id_voucher),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function get_table_detail_voucher_mitra($id_voucher)
    {
        $resultss = $this->Global_model->get_table_detail_voucher($id_voucher);
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_voucher_detail;
            $row[] =  "Rp " . number_format($angga->harga_voucher_detail);
            $row[] =  "Rp " . number_format($angga->harga_jual_voucher_detail);
            $row[] =  $angga->kode_voucher_detail;
            $row[] =  $angga->jenis_voucher_detail;
            if ($angga->sts_terjual == 1) {
                $row[] = '<small class="badge badge-success"> Terjual</small>';
            } else {
                $row[] = '<small class="badge badge-danger"> Belum Terjual</small>';
            }

            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id_detail_voucher(' . "'" . $angga->id_detail_voucher . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_detail_voucher($id_voucher),
            "recordsFiltered" => $this->Global_model->count_filtered_data_detail_voucher($id_voucher),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_detail_voucher($id_detail_voucher)
    {

        $get_detail_voucher = $this->Global_model->by_id_detail_voucher($id_detail_voucher);
        $output = [
            "get_detail_voucher" => $get_detail_voucher,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }
    public function tambah_detail_voucher()
    {
        $id_voucher = $this->input->post('id_voucher');
        $kode_voucher_detail = $this->input->post('kode_voucher_detail');
        $username_voucher = $this->input->post('username_voucher');
        $password_voucher = $this->input->post('password_voucher');
        $row_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $data = [
            'id_voucher' => $row_voucher['id_voucher'],
            'nama_voucher_detail' => $row_voucher['nama_voucher'],
            'harga_voucher_detail' => $row_voucher['harga_voucher'],
            'harga_jual_voucher_detail' => $row_voucher['harga_voucher'],
            'kode_voucher_detail' => $kode_voucher_detail,
            'jenis_voucher_detail' => $row_voucher['jenis_voucher'],
            'username_voucher' => $username_voucher,
            'password_voucher' => $password_voucher,
        ];
        $this->Global_model->add_detail_voucher($data);
        $count_voucher = $this->Global_model->count_voucher($id_voucher);
        $where = [
            'id_voucher' => $id_voucher
        ];
        $data = [
            'qty_voucher' => $count_voucher,
        ];
        $this->Global_model->update_voucher($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function tambah_detail_voucher_mitra()
    {
        $id_voucher = $this->input->post('id_voucher');
        $kode_voucher_detail = $this->input->post('kode_voucher_detail');
        $username_voucher = $this->input->post('username_voucher');
        $password_voucher = $this->input->post('password_voucher');
        $row_voucher = $this->Global_model->by_id_voucher($id_voucher);
        $data = [
            'id_voucher' => $row_voucher['id_voucher'],
            'nama_voucher_detail' => $row_voucher['nama_voucher'],
            'harga_voucher_detail' => $row_voucher['harga_voucher'],
            'harga_jual_voucher_detail' => $row_voucher['harga_jual'],
            'kode_voucher_detail' => $kode_voucher_detail,
            'jenis_voucher_detail' => $row_voucher['jenis_voucher'],
            'username_voucher' => $username_voucher,
            'password_voucher' => $password_voucher,
        ];
        $this->Global_model->add_detail_voucher($data);
        $count_voucher = $this->Global_model->count_voucher($id_voucher);
        $where = [
            'id_voucher' => $id_voucher
        ];
        $data = [
            'qty_voucher' => $count_voucher,
        ];
        $this->Global_model->update_voucher($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function hapus_detail_voucher($id_detail_voucher)
    {
        $id_voucher = $this->input->post('id_voucher');
        $this->Global_model->delete_detail_voucher($id_detail_voucher);
        $count_voucher = $this->Global_model->count_voucher($id_voucher);
        $where = [
            'id_voucher' => $id_voucher
        ];
        $data = [
            'qty_voucher' => $count_voucher,
        ];
        $this->Global_model->update_voucher($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    function voucher_mitra_konter()
    {
        $data['title'] = 'DATA KONTER';
        $data['result_lokasi'] = $this->Global_model->result_lokasi();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('konter/mitra', $data);
        $this->load->view('template/footer');
        $this->load->view('konter/ajax_mitra');
    }


    function kelola_voucher_mitra_konter($id_user)
    {
        $data['id_user'] = $id_user;
        $data['title'] = 'DATA VOUCHER MITRA';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('voucer/voucher_mitra', $data);
        $this->load->view('template/footer');
        $this->load->view('voucer/ajax_mitra');
    }


    public function get_table_user_konter_mitra()
    {
        $resultss = $this->Global_model->get_table_user_konter();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_user;
            $row[] =  $angga->telepone;
            $row[] =  $angga->kode_referal;
            $row[] =  $angga->alamat;
            $row[] =  $angga->nama_lokasi;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-info" onClick="by_id(' . "'" . $angga->id_user . "','masukan_voucher'" . ')"><i class="fa fa-id-card" aria-hidden="true"></i> Kelola Voucher </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_user(),
            "recordsFiltered" => $this->Global_model->count_filtered_data_user(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }


    public function get_table_voucher_mitra($id_user)
    {
        $resultss = $this->Global_model->get_table_voucher_mitra($id_user);
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $count_voucher_detail = $this->Global_model->count_voucher($angga->id_voucher);
            $row[] = ++$no;
            $row[] =  ' <a href="' . base_url('foto_iklan/') . $angga->foto_voucher . '"><img src="' . base_url('foto_iklan/') . $angga->foto_voucher . '" style="width:100px;" alt=""></a>';
            $row[] =  $angga->nama_voucher;
            $row[] =  $angga->jenis_voucher;
            $row[] =  "Rp " . number_format($angga->harga_voucher);
            $row[] =  "Rp " . number_format($angga->harga_jual);
            $row[] = $count_voucher_detail;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-info" onClick="by_id(' . "'" . $angga->id_voucher . "','detail'" . ')"><i class="fas fa fa-eye"></i> Buat Detail Voucher </a> <a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_voucher . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_voucher . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_model->count_all_data_voucher_mitra($id_user),
            "recordsFiltered" => $this->Global_model->count_filtered_data_voucher_mitra($id_user),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    function cek_keranjang($id_user)
    {
        $result_keranjang = $this->Global_model->cek_keranjnag_saya($id_user);
    }

    function PembayaranBerhasil()
    {
        $headers = $this->input->request_headers();
        $callbackKey = isset($headers['X-CALLBACK-TOKEN']) ? $headers['X-CALLBACK-TOKEN'] : '';
        $validKey = '7pBPrjKyRGztyBFduaE8ObOoiD6vvysSeFRmNpOmy7ZEDQVs';
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
            $this->Global_model->update_ke_transaksi($datakirim, $where);
            // Masukan Data Ke Bagian Konter

            // Lakukan apa pun yang perlu dilakukan dengan data callback invoice

            // Mengirimkan respons sukses ke Xendit
            http_response_code(200);
            redirect('customer/pembayaranberhasil');
        } else {
            // Kunci callback tidak valid, tidak memproses callback invoice

            // Mengirimkan respons error ke Xendit
            http_response_code(401);
            echo 'Unauthorized';
        }
    }
}
