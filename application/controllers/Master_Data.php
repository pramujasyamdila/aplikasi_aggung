<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_Data extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('PaketBulanan_model');
        $this->load->model('Auth_model');
        $this->load->library(array('form_validation', 'recaptcha'));
    }
    function klasifikasi_harga()
    {
        $data['title'] = 'Klasifikasi Harga';

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('master-data/klasifikasi/index', $data);
        $this->load->view('template/footer');
    }

    function paket_bulanan()
    {
        $data['title'] = 'Paket Bulanan';
        $data['paket_bulanan'] = $this->PaketBulanan_model->get_all();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('master-data/paket-bulanan/index', $data);
        $this->load->view('template/footer');
    }

    // add data paket

    public function simpan()
    {
        $data = array(
            'nama_paket_bulanan' => $this->input->post('nama_paket_bulanan'),
            'harga_paket_bulanan' => $this->input->post('harga_paket_bulanan')
        );
        $this->PaketBulanan_model->insert($data);
        redirect('master_data/paket_bulanan');
    }
    //hapus 
    public function hapus($id)
    {
        $this->PaketBulanan_model->delete($id);
        redirect('master_data/paket_bulanan');
    }

    //form ubah

    public function ubah($id)
    {
        $data['title'] = 'Update Form Paket Bulanan';

        $data['paket'] = $this->PaketBulanan_model->get_by_id($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('master-data/paket-bulanan/ubah', $data);
        $this->load->view('template/footer');
    }


    //update data form
    public function update()
    {
        $id = $this->input->post('id');
        $data = array(
            'nama_paket_bulanan' => $this->input->post('nama_paket_bulanan'),
            'harga_paket_bulanan' => $this->input->post('harga_paket_bulanan')
        );
        $this->PaketBulanan_model->update($id, $data);
        redirect('master_data/paket_bulanan');
    }




    function voucher_konter()
    {
        $data['title'] = 'Voucher Mitra/Konter';

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('master-data/voucher-konter/index', $data);
        $this->load->view('template/footer');
    }
}
