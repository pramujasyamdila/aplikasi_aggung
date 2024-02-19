<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Genetika extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Paket/Paket_model');
        $this->load->model('Global/Global_genetika');
        $this->load->model('Auth_model');
        $this->load->library(array('form_validation', 'recaptcha'));
    }

    // user
    function user()
    {
        $data['title'] = 'Master User';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/index', $data);
        $this->load->view('template/footer');
        $this->load->view('pegawai/ajax');
    }

    function edit_user($id_user)
    {
        $data['title'] = 'Edit User';
        $data['row_user'] = $this->Global_genetika->by_id_user($id_user);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('pegawai/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('pegawai/ajax');
    }
    public function get_table_user()
    {
        $resultss = $this->Global_genetika->get_table_user();
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
            "recordsTotal" => $this->Global_genetika->count_all_data_user(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_user(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_user($id_user)
    {

        $get_user = $this->Global_genetika->by_id_user($id_user);
        $output = [
            "get_user" => $get_user,

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
            'id_role' => 1,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];
        $this->Global_genetika->add_user($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_user($id_user)
    {
        $this->Global_genetika->delete_user($id_user);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_user_post()
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
        $this->Global_genetika->update_user($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    // jabatan
    function jabatan()
    {
        $data['title'] = 'Master Jabatan';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('jabatan/index', $data);
        $this->load->view('template/footer');
        $this->load->view('jabatan/ajax');
    }

    function edit_jabatan($id_jabatan)
    {
        $data['title'] = 'Edit Jabatan';
        $data['row_jabatan'] = $this->Global_genetika->by_id_jabatan($id_jabatan);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('jabatan/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('jabatan/ajax');
    }
    public function get_table_jabatan()
    {
        $resultss = $this->Global_genetika->get_table_jabatan();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->kode_jabatan;
            $row[] =  $angga->nama_jabatan;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_jabatan . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_jabatan . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_genetika->count_all_data_jabatan(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_jabatan(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_jabatan($id_jabatan)
    {

        $get_jabatan = $this->Global_genetika->by_id_jabatan($id_jabatan);
        $output = [
            "get_jabatan" => $get_jabatan,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_jabatan()
    {
        $nama_jabatan = $this->input->post('nama_jabatan');
        $kode_jabatan = $this->input->post('kode_jabatan');
        $data = [
            'nama_jabatan' => $nama_jabatan,
            'kode_jabatan' => $kode_jabatan,
        ];
        $this->Global_genetika->add_jabatan($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_jabatan($id_jabatan)
    {
        $this->Global_genetika->delete_jabatan($id_jabatan);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_jabatan_post()
    {
        $where = [
            'id_jabatan' => $this->input->post('id_jabatan')
        ];

        $nama_jabatan = $this->input->post('nama_jabatan');
        $kode_jabatan = $this->input->post('kode_jabatan');
        $data = [
            'nama_jabatan' => $nama_jabatan,
            'kode_jabatan' => $kode_jabatan,
        ];
        $this->Global_genetika->update_jabatan($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }


    // divisi
    function divisi()
    {
        $data['title'] = 'Master divisi';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('divisi/index', $data);
        $this->load->view('template/footer');
        $this->load->view('divisi/ajax');
    }

    function edit_divisi($id_divisi)
    {
        $data['title'] = 'Edit divisi';
        $data['row_divisi'] = $this->Global_genetika->by_id_divisi($id_divisi);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('divisi/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('divisi/ajax');
    }
    public function get_table_divisi()
    {
        $resultss = $this->Global_genetika->get_table_divisi();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->kode_divisi;
            $row[] =  $angga->nama_divisi;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_divisi . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_divisi . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_genetika->count_all_data_divisi(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_divisi(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_divisi($id_divisi)
    {

        $get_divisi = $this->Global_genetika->by_id_divisi($id_divisi);
        $output = [
            "get_divisi" => $get_divisi,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_divisi()
    {
        $nama_divisi = $this->input->post('nama_divisi');
        $kode_divisi = $this->input->post('kode_divisi');
        $data = [
            'nama_divisi' => $nama_divisi,
            'kode_divisi' => $kode_divisi,
        ];
        $this->Global_genetika->add_divisi($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_divisi($id_divisi)
    {
        $this->Global_genetika->delete_divisi($id_divisi);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_divisi_post()
    {
        $where = [
            'id_divisi' => $this->input->post('id_divisi')
        ];

        $nama_divisi = $this->input->post('nama_divisi');
        $kode_divisi = $this->input->post('kode_divisi');
        $data = [
            'nama_divisi' => $nama_divisi,
            'kode_divisi' => $kode_divisi,
        ];
        $this->Global_genetika->update_divisi($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    // ruangan
    function ruangan()
    {
        $data['title'] = 'Master ruangan';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('ruangan/index', $data);
        $this->load->view('template/footer');
        $this->load->view('ruangan/ajax');
    }

    function edit_ruangan($id_ruangan)
    {
        $data['title'] = 'Edit ruangan';
        $data['row_ruangan'] = $this->Global_genetika->by_id_ruangan($id_ruangan);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('ruangan/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('ruangan/ajax');
    }
    public function get_table_ruangan()
    {
        $resultss = $this->Global_genetika->get_table_ruangan();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->kode_ruangan;
            $row[] =  $angga->nama_ruangan;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_ruangan . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_ruangan . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_genetika->count_all_data_ruangan(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_ruangan(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_ruangan($id_ruangan)
    {

        $get_ruangan = $this->Global_genetika->by_id_ruangan($id_ruangan);
        $output = [
            "get_ruangan" => $get_ruangan,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_ruangan()
    {
        $nama_ruangan = $this->input->post('nama_ruangan');
        $kode_ruangan = $this->input->post('kode_ruangan');
        $data = [
            'nama_ruangan' => $nama_ruangan,
            'kode_ruangan' => $kode_ruangan,
        ];
        $this->Global_genetika->add_ruangan($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_ruangan($id_ruangan)
    {
        $this->Global_genetika->delete_ruangan($id_ruangan);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_ruangan_post()
    {
        $where = [
            'id_ruangan' => $this->input->post('id_ruangan')
        ];

        $nama_ruangan = $this->input->post('nama_ruangan');
        $kode_ruangan = $this->input->post('kode_ruangan');
        $data = [
            'nama_ruangan' => $nama_ruangan,
            'kode_ruangan' => $kode_ruangan,
        ];
        $this->Global_genetika->update_ruangan($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    // waktu
    function waktu()
    {
        $data['title'] = 'Master waktu';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('waktu/index', $data);
        $this->load->view('template/footer');
        $this->load->view('waktu/ajax');
    }

    function edit_waktu($id_waktu)
    {
        $data['title'] = 'Edit waktu';
        $data['row_waktu'] = $this->Global_genetika->by_id_waktu($id_waktu);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('waktu/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('waktu/ajax');
    }
    public function get_table_waktu()
    {
        $resultss = $this->Global_genetika->get_table_waktu();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->kode_waktu;
            $row[] =  $angga->nama_waktu;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_waktu . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_waktu . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_genetika->count_all_data_waktu(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_waktu(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_waktu($id_waktu)
    {

        $get_waktu = $this->Global_genetika->by_id_waktu($id_waktu);
        $output = [
            "get_waktu" => $get_waktu,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_waktu()
    {
        $nama_waktu = $this->input->post('nama_waktu');
        $kode_waktu = $this->input->post('kode_waktu');
        $data = [
            'nama_waktu' => $nama_waktu,
            'kode_waktu' => $kode_waktu,
        ];
        $this->Global_genetika->add_waktu($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_waktu($id_waktu)
    {
        $this->Global_genetika->delete_waktu($id_waktu);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_waktu_post()
    {
        $where = [
            'id_waktu' => $this->input->post('id_waktu')
        ];

        $nama_waktu = $this->input->post('nama_waktu');
        $kode_waktu = $this->input->post('kode_waktu');
        $data = [
            'nama_waktu' => $nama_waktu,
            'kode_waktu' => $kode_waktu,
        ];
        $this->Global_genetika->update_waktu($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    // hari
    function hari()
    {
        $data['title'] = 'Master hari';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('hari/index', $data);
        $this->load->view('template/footer');
        $this->load->view('hari/ajax');
    }

    function edit_hari($id_hari)
    {
        $data['title'] = 'Edit hari';
        $data['row_hari'] = $this->Global_genetika->by_id_hari($id_hari);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('hari/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('hari/ajax');
    }
    public function get_table_hari()
    {
        $resultss = $this->Global_genetika->get_table_hari();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->kode_hari;
            $row[] =  $angga->nama_hari;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_hari . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_hari . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_genetika->count_all_data_hari(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_hari(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_hari($id_hari)
    {

        $get_hari = $this->Global_genetika->by_id_hari($id_hari);
        $output = [
            "get_hari" => $get_hari,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_hari()
    {
        $nama_hari = $this->input->post('nama_hari');
        $kode_hari = $this->input->post('kode_hari');
        $data = [
            'nama_hari' => $nama_hari,
            'kode_hari' => $kode_hari,
        ];
        $this->Global_genetika->add_hari($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_hari($id_hari)
    {
        $this->Global_genetika->delete_hari($id_hari);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_hari_post()
    {
        $where = [
            'id_hari' => $this->input->post('id_hari')
        ];

        $nama_hari = $this->input->post('nama_hari');
        $kode_hari = $this->input->post('kode_hari');
        $data = [
            'nama_hari' => $nama_hari,
            'kode_hari' => $kode_hari,
        ];
        $this->Global_genetika->update_hari($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    // meeting
    function meeting()
    {
        $data['title'] = 'Master meeting';
        // jabatan
        $data['jabatan'] = $this->Global_genetika->by_id_result_jabatan();
        // divisi
        $data['divisi'] = $this->Global_genetika->by_id_result_divisi();
        // waktu
        $data['waktu'] = $this->Global_genetika->by_id_result_waktu();
        // hari
        $data['hari'] = $this->Global_genetika->by_id_result_hari();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('meeting/index', $data);
        $this->load->view('template/footer');
        $this->load->view('meeting/ajax');
    }

    function edit_meeting($id_meeting)
    {
        $data['title'] = 'Edit meeting';
        // jabatan
        $data['jabatan'] = $this->Global_genetika->by_id_result_jabatan();
        // divisi
        $data['divisi'] = $this->Global_genetika->by_id_result_divisi();
        // waktu
        $data['waktu'] = $this->Global_genetika->by_id_result_waktu();
        // hari
        $data['hari'] = $this->Global_genetika->by_id_result_hari();
        $data['row_meeting'] = $this->Global_genetika->by_id_meeting($id_meeting);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('meeting/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('meeting/ajax');
    }
    public function get_table_meeting()
    {
        $resultss = $this->Global_genetika->get_table_meeting();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->kode_meeting;
            $row[] =  $angga->nama_meeting;
            $row[] =  $angga->nama_jabatan;
            $row[] =  $angga->nama_divisi;
            $row[] =  $angga->nama_waktu;
            $row[] =  $angga->nama_hari;
            $row[] =  $angga->tanggal;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-warning" onClick="by_id(' . "'" . $angga->id_meeting . "','edit'" . ')"><i class="fas fa fa-edit"></i> Edit </a> <a href="javascript:;"  class="btn btn-sm btn-danger" onClick="by_id(' . "'" . $angga->id_meeting . "','hapus'" . ')"><i class="fas fa fa-trash"></i> Hapus </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_genetika->count_all_data_meeting(),
            "recordsFiltered" => $this->Global_genetika->count_filtered_data_meeting(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_meeting($id_meeting)
    {

        $get_meeting = $this->Global_genetika->by_id_meeting($id_meeting);
        $output = [
            "get_meeting" => $get_meeting,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function tambah_meeting()
    {
        $nama_meeting = $this->input->post('nama_meeting');
        $kode_meeting = $this->input->post('kode_meeting');
        // jabatan
        $id_jabatan = $this->input->post('id_jabatan');
        // divisi
        $id_divisi = $this->input->post('id_divisi');
        // waktu
        $id_waktu = $this->input->post('id_waktu');
        // hari
        $id_hari = $this->input->post('id_hari');
        $tanggal = $this->input->post('tanggal');
        $data = [
            'nama_meeting' => $nama_meeting,
            'kode_meeting' => $kode_meeting,
            // id_jabatan
            'id_jabatan' => $id_jabatan,
            // id_divisi
            'id_divisi' => $id_divisi,
            // id_waktu
            'id_waktu' => $id_waktu,
            // id_hari
            'id_hari' => $id_hari,
            'tanggal' => $tanggal,
        ];
        $this->Global_genetika->add_meeting($data);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    public function hapus_meeting($id_meeting)
    {
        $this->Global_genetika->delete_meeting($id_meeting);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_meeting_post()
    {
        $where = [
            'id_meeting' => $this->input->post('id_meeting')
        ];

        $nama_meeting = $this->input->post('nama_meeting');
        $tanggal = $this->input->post('tanggal');
        $kode_meeting = $this->input->post('kode_meeting');
        // jabatan
        $id_jabatan = $this->input->post('id_jabatan');
        // divisi
        $id_divisi = $this->input->post('id_divisi');
        // waktu
        $id_waktu = $this->input->post('id_waktu');
        // hari
        $id_hari = $this->input->post('id_hari');
        $data = [
            'nama_meeting' => $nama_meeting,
            'tanggal' => $tanggal,
            'kode_meeting' => $kode_meeting,
            // id_jabatan
            'id_jabatan' => $id_jabatan,
            // id_divisi
            'id_divisi' => $id_divisi,
            // id_waktu
            'id_waktu' => $id_waktu,
            // id_hari
            'id_hari' => $id_hari,
        ];
        $this->Global_genetika->update_meeting($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }


    // meeting
    function generate_jadwal()
    {
        $data['title'] = 'Master meeting';
        // jabatan
        $data['jabatan'] = $this->Global_genetika->by_id_result_jabatan();
        // divisi
        $data['divisi'] = $this->Global_genetika->by_id_result_divisi();
        // waktu
        $data['waktu'] = $this->Global_genetika->by_id_result_waktu();
        // hari
        $data['hari'] = $this->Global_genetika->by_id_result_hari();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('generate_jadwal/index', $data);
        $this->load->view('template/footer');
        $this->load->view('generate_jadwal/ajax');
    }


    public function buat_jadwal_meeting()
    {
        // Ambil data jadwal dan ruangan dari database
        $schedules = $this->Global_genetika->ambil_data_meeting();
        $rooms = $this->Global_genetika->ambil_ruangan();
        // Implementasikan algoritma genetika
        $optimized_schedule = $this->genetic_algorithm($schedules, $rooms);

        // Tampilkan hasil ke view
        $data['title'] = 'Generate Jadwal Ruangan Meeting';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('schedule_view', [
            'schedules' => $schedules,
            'rooms' => $rooms,
            'optimized_schedule' => $optimized_schedule
        ]);
        $this->load->view('template/footer');
        $this->load->view('meeting/ajax');
    }

    private function genetic_algorithm($schedules, $rooms)
    {
        // Inisialisasi populasi awal
        $population_size = 50;
        $population = $this->initialize_population($population_size, $schedules, $rooms);

        // Evaluasi populasi
        $fitness_scores = $this->evaluate_population($population, $schedules, $rooms);

        // Loop generasi
        $num_generations = 100;
        for ($generation = 0; $generation < $num_generations; $generation++) {
            // Seleksi
            $selected_parents = $this->selection($population, $fitness_scores);

            // Crossover
            $offspring = $this->crossover($selected_parents);

            // Mutasi
            $population = $this->mutation($offspring, $rooms);

            // Evaluasi populasi yang baru
            $fitness_scores = $this->evaluate_population($population, $schedules, $rooms);
        }

        // Pilih individu terbaik
        $best_individual_index = array_search(max($fitness_scores), $fitness_scores);
        return $population[$best_individual_index];
    }

    private function initialize_population($population_size, $schedules, $rooms)
    {
        $population = array();
        for ($i = 0; $i < $population_size; $i++) {
            shuffle($rooms);
            $schedule_mapping = array();
            foreach ($schedules as $schedule) {
                $random_room = $rooms[array_rand($rooms)];
                $schedule_mapping[] = array(
                    'nama_divisi' => $schedule['nama_divisi'],
                    'nama_jabatan' => $schedule['nama_jabatan'],
                    'tanggal' => $schedule['tanggal'],
                    'nama_hari' => $schedule['nama_hari'],
                    'nama_meeting' => $schedule['nama_meeting'],
                    'room' => $random_room['nama_ruangan']
                );
            }
            $population[] = $schedule_mapping;
        }
        return $population;
    }

    private function evaluate_population($population)
    {
        $fitness_scores = array();
        foreach ($population as $individual) {
            $overlap_count = 0;
            $room_usage = array(); // Untuk melacak penggunaan ruangan

            foreach ($individual as $schedule) {
                $room_name = $schedule['room'];

                // Periksa apakah ruangan sudah digunakan pada waktu tertentu
                if (!isset($room_usage[$room_name])) {
                    $room_usage[$room_name] = array();
                }
                $room_schedule = $room_usage[$room_name];

                // Periksa tumpang tindih dengan jadwal sebelumnya di ruangan yang sama
                foreach ($room_schedule as $existing_schedule) {
                    if ($this->check_overlap($schedule, $existing_schedule)) {
                        $overlap_count++;
                        break;
                    }
                }

                // Tambahkan jadwal ke penggunaan ruangan
                $room_usage[$room_name][] = $schedule;
            }

            // Hitung fitness score berdasarkan tumpang tindih
            // Nilai fitness score invers dengan jumlah tumpang tindih
            $fitness_score = 100 - ($overlap_count * 5); // Misalnya, setiap tumpang tindih mengurangi 5 poin dari nilai fitness
            $fitness_scores[] = max(0, $fitness_score); // Pastikan nilai fitness tidak negatif
        }
        return $fitness_scores;
    }

    // Fungsi untuk memeriksa tumpang tindih antara dua jadwal
    private function check_overlap($schedule1, $schedule2)
    {
        $start_tanggal1 = strtotime($schedule1['tanggal']);
        $end_tanggal1 = strtotime('+1 hour', $start_tanggal1); // Misalnya, jadwal setiap pertemuan berlangsung selama satu jam
        $start_tanggal2 = strtotime($schedule2['tanggal']);
        $end_tanggal2 = strtotime('+1 hour', $start_tanggal2);

        // Tidak ada tumpang tindih jika salah satu jadwal dimulai setelah yang lain selesai, atau sebaliknya
        return !($end_tanggal1 <= $start_tanggal2 || $end_tanggal2 <= $start_tanggal1);
    }


    private function selection($population, $fitness_scores)
    {
        // Seleksi menggunakan turnamen
        $selected_parents = array();
        $tournament_size = 5;
        for ($i = 0; $i < count($population); $i++) {
            $tournament_individuals = array_rand($population, $tournament_size);
            $best_individual_index = array_search(max(array_intersect_key($fitness_scores, array_flip($tournament_individuals))), $tournament_individuals);
            $selected_parents[] = $population[$best_individual_index];
        }
        return $selected_parents;
    }

    private function crossover($selected_parents)
    {
        // Crossover menggunakan satu titik potong
        $offspring = array();
        $crossover_rate = 0.8; // Tingkat crossover
        $num_offspring = count($selected_parents);
        for ($i = 0; $i < $num_offspring; $i += 2) {
            if (rand(0, 100) / 100 < $crossover_rate) {
                $crossover_point = rand(1, count($selected_parents[$i]) - 1);
                $offspring1 = array_merge(array_slice($selected_parents[$i], 0, $crossover_point), array_slice($selected_parents[$i + 1], $crossover_point));
                $offspring2 = array_merge(array_slice($selected_parents[$i + 1], 0, $crossover_point), array_slice($selected_parents[$i], $crossover_point));
                $offspring[] = $offspring1;
                $offspring[] = $offspring2;
            } else {
                $offspring[] = $selected_parents[$i];
                $offspring[] = $selected_parents[$i + 1];
            }
        }
        return $offspring;
    }

    private function mutation($offspring, $room)
    {
        // Mutasi dengan mengganti ruangan secara acak
        $mutation_rate = 0.1; // Tingkat mutasi
        foreach ($offspring as &$individual) {
            foreach ($individual as &$schedule) {
                if (rand(0, 100) / 100 < $mutation_rate) {
                    $schedule['room'] = $room[array_rand($room)]['nama_ruangan'];
                }
            }
        }
        return $offspring;
    }
}
