<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Paket/Paket_model');
        $this->load->model('Auth_model');
        $this->load->model('dashboard_model');
        $this->load->library(array('form_validation', 'recaptcha'));
    }
    function index()
    {
        $data['title'] = 'Dashboard';

        $data['jml_pelanggan_voucher'] = $this->dashboard_model->Pelanggan_voucher();
        $data['jml_pelanggan_konter'] = $this->dashboard_model->Pelanggan_konter();
        $data['jml_pengguna'] = $this->dashboard_model->Get_tbl_User();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
        $this->load->view('dashboard/ajax');
    }
}
