<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->model('Auth_model');
        $this->load->library(array('form_validation', 'recaptcha'));
        $this->load->model('Paket/Paket_model');
        $this->load->model('Global/Global_model');
    }
    function mitra()
    {
        $data['title'] = 'Pembayaran Mitra';
        $data['sudah_bayar'] = $this->Global_model->count_riwayat_pembayaran_sudah_bayar_pelanggan();
        $data['belum_bayar'] = $this->Global_model->count_riwayat_pembayaran_belum_bayar_pelanggan();

        $data['result_riwayat'] = $this->Global_model->result_pembayaran_laporan_pelanggan();
        $data['riwayat_pemabayaran'] = $this->Global_model->result_pembayaran_sudah_laporan_pelanggan();
        $data['riwayat_pemabayaran_belum'] = $this->Global_model->result_pembayaran_belum_laporan_pelanggan();
        
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('pembayaran/mitra/index', $data);
        $this->load->view('template/footer');
    }

    function pelanggan()
    {
        $data['sudah_bayar'] = $this->Global_model->count_riwayat_pembayaran_sudah_bayar_pelanggan();
        $data['belum_bayar'] = $this->Global_model->count_riwayat_pembayaran_belum_bayar_pelanggan();

        $data['result_riwayat'] = $this->Global_model->result_pembayaran_laporan_pelanggan();
        $data['riwayat_pemabayaran'] = $this->Global_model->result_pembayaran_sudah_laporan_pelanggan();
        $data['riwayat_pemabayaran_belum'] = $this->Global_model->result_pembayaran_belum_laporan_pelanggan();

        $data['title'] = 'Pembayaran Pelanggan Umum Voucher';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('pembayaran/pelanggan/index', $data);
        $this->load->view('template/footer');
    }

    function bulanan()
    {
        $data['title'] = 'Pembayaran Pelanggan Bulanan';
        $data['sudah_bayar'] = $this->Global_model->count_riwayat_pembayaran_sudah_bayar();
        $data['belum_bayar'] = $this->Global_model->count_riwayat_pembayaran_belum_bayar();

        $data['result_riwayat'] = $this->Global_model->result_pembayaran_laporan();
        $data['riwayat_pemabayaran'] = $this->Global_model->result_pembayaran_sudah_laporan();
        $data['riwayat_pemabayaran_belum'] = $this->Global_model->result_pembayaran_belum_laporan();
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('pembayaran/bulanan/index', $data);
        $this->load->view('template/footer');
    }
}
