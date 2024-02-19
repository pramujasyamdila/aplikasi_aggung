<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require_once APPPATH . 'third_party/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

class Spk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Paket/Paket_model');
        $this->load->model('Global/Global_spk');
        $this->load->model('Auth_model');
        $this->load->library(array('form_validation', 'recaptcha'));
    }

    // lamaran
    function data_pelamar()
    {
        $data['title'] = 'Data Lamaran';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('lamaran/index', $data);
        $this->load->view('template/footer');
        $this->load->view('lamaran/ajax');
    }

    function data_kandidat()
    {
        $data['title'] = 'Data Kandidat';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('lamaran/kandidat', $data);
        $this->load->view('template/footer');
        $this->load->view('lamaran/ajax');
    }

    function generate_hasil()
    {
        $data['title'] = 'Hasil Generate';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('lamaran/perhitungan', $data);
        $this->load->view('template/footer');
        $this->load->view('lamaran/ajax');
    }

    function edit_lamaran($id_lamaran)
    {
        $data['title'] = 'Beri Penilaian';
        $data['row_lamaran'] = $this->Global_spk->by_id_lamaran($id_lamaran);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('lamaran/edit', $data);
        $this->load->view('template/footer');
        $this->load->view('lamaran/ajax');
    }

    function detail_lamaran($id_lamaran)
    {
        $data['title'] = 'Beri Penilaian';
        $data['row_lamaran'] = $this->Global_spk->by_id_lamaran($id_lamaran);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar', $data);
        $this->load->view('template/sidebar');
        $this->load->view('lamaran/detail', $data);
        $this->load->view('template/footer');
        $this->load->view('lamaran/ajax');
    }

    public function get_table_lamaran()
    {
        $resultss = $this->Global_spk->get_table_lamaran();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_lengkap;
            $row[] =  $angga->nomor_telepon;
            $row[] =  $angga->email;
            $row[] =  $angga->tingkat_pendidikan;
            $row[] =  $angga->nama_institusi_pendidikan;
            $row[] =  $angga->nama_gelar;
            $row[] = '<a href="javascript:;"  class="btn btn-sm btn-block btn-primary" onClick="by_id(' . "'" . $angga->id_lamaran . "','detail'" . ')"><i class="fas fa fa-eye"></i> </a> <a href="javascript:;"  class="btn btn-sm btn-block btn-warning" onClick="by_id(' . "'" . $angga->id_lamaran . "','edit'" . ')"><i class="fas fa fa-edit"></i> </a> <a href="javascript:;"  class="btn btn-sm btn-block btn-danger" onClick="by_id(' . "'" . $angga->id_lamaran . "','hapus'" . ')"><i class="fas fa fa-trash"></i> </a>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_spk->count_all_data_lamaran(),
            "recordsFiltered" => $this->Global_spk->count_filtered_data_lamaran(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function get_table_kandidat()
    {
        $resultss = $this->Global_spk->get_table_kandidat();
        $data = [];
        $no = $_POST['start'];
        foreach ($resultss as $angga) {
            $row = array();
            $row[] = ++$no;
            $row[] =  $angga->nama_lengkap;
            $row[] =  $angga->education;
            $row[] =  $angga->experience;
            $row[] =  $angga->skills;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Global_spk->count_all_data_kandidat(),
            "recordsFiltered" => $this->Global_spk->count_filtered_data_kandidat(),
            "data" => $data
        );
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function by_id_lamaran($id_lamaran)
    {

        $get_lamaran = $this->Global_spk->by_id_lamaran($id_lamaran);
        $output = [
            "get_lamaran" => $get_lamaran,

        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function hapus_lamaran($id_lamaran)
    {
        $this->Global_spk->delete_lamaran($id_lamaran);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }
    public function edit_lamaran_post()
    {
        $where = [
            'id_lamaran' => $this->input->post('id_lamaran')
        ];

        $education = $this->input->post('education');
        $experience = $this->input->post('experience');
        $skills = $this->input->post('skills');
        $data = [
            'education' => $education,
            'experience' => $experience,
            'skills' => $skills,
        ];
        $this->Global_spk->update_lamaran($data, $where);
        $this->output->set_content_type('application/json')->set_output(json_encode('success'));
    }

    function kirim_interview($id_lamaran)
    {
        $pesan = 'Anda Menerima Interview Di Perusahaan Kami (PT JASAMARGA) Hub : 08978201075 Agar Lebih Lanjutnya';
        $this->kirim_wa->kirim_wa($id_lamaran, $pesan);
        redirect('spk/generate_hasil');
    }
    public function kirim_lamaran_saya()
    {
        $nama_lengkap = $this->input->post('nama_lengkap');
        $nomor_telepon = $this->input->post('nomor_telepon');
        $email = $this->input->post('email');
        $kewarganegaraan = $this->input->post('kewarganegaraan');
        $alamat_lengkap = $this->input->post('alamat_lengkap');
        $tingkat_pendidikan = $this->input->post('tingkat_pendidikan');
        $nama_institusi_pendidikan = $this->input->post('nama_institusi_pendidikan');
        $nama_gelar = $this->input->post('nama_gelar');
        $tahun_lulus = $this->input->post('tahun_lulus');
        $nama_institusi_pekerjaan = $this->input->post('nama_institusi_pekerjaan');
        $nama_jabatan = $this->input->post('nama_jabatan');
        $lama_bekerja = $this->input->post('lama_bekerja');
        $tanggung_jawab = $this->input->post('tanggung_jawab');
        $pengalaman_kerja_lainya = $this->input->post('pengalaman_kerja_lainya');
        $keterampilan = $this->input->post('keterampilan');
        $bahasa_keterampilan = $this->input->post('bahasa_keterampilan');
        $config['upload_path'] = './file_cv/';
        $config['allowed_types'] = 'pdf|png|jpeg';
        $config['max_size'] = 0;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $upload = [
                'nama_lengkap' => $nama_lengkap,
                'nomor_telepon' => $nomor_telepon,
                'email' => $email,
                'kewarganegaraan' => $kewarganegaraan,
                'alamat_lengkap' => $alamat_lengkap,
                'tingkat_pendidikan' => $tingkat_pendidikan,
                'nama_institusi_pendidikan' => $nama_institusi_pendidikan,
                'nama_gelar' => $nama_gelar,
                'tahun_lulus' => $tahun_lulus,
                'nama_institusi_pekerjaan' => $nama_institusi_pekerjaan,
                'nama_jabatan' => $nama_jabatan,
                'lama_bekerja' => $lama_bekerja,
                'tanggung_jawab' => $tanggung_jawab,
                'pengalaman_kerja_lainya' => $pengalaman_kerja_lainya,
                'keterampilan' => $keterampilan,
                'bahasa_keterampilan' => $bahasa_keterampilan,
                'file' => $fileData['file_name'],
            ];
            $this->Global_spk->add_lamaran($upload);
            $this->session->set_flashdata('pesan', 'Anda Berhasil Mengirim Lamaran Kerja Anda');
            redirect('home');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect(base_url('upload'));
        }
    }
}
