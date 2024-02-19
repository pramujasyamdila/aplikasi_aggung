<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Xendit\Xendit;

class Pemesanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'recaptcha'));
        $this->load->model('Unit_kerja/Unit_kerja_model');
        $this->load->model('Paket/Paket_model');
        $this->load->model('Wilayah/Wilayah_model');
        $this->load->model('Produk_negri/Produk_negri_model');
        $this->load->model('Jenis_pengadaan/Jenis_pengadaan_model');
        $this->load->model('Tahun_anggaran/Tahun_anggaran_model');
        $this->load->model("Metode_pemilihan/Metode_pemilihan_model");
        $this->load->model('Kualifikasi/Kualifikasi_model');
    }

    function index()
    {
        $this->load->view('checkout');
    }
    function kirim()
    {
        $external_id = $this->input->post('external_id');
        $email = $this->input->post('email');
        $nama_customer = $this->input->post('nama_customer');
        $keterangan = $this->input->post('keterangan');
        $nama_voucher = $this->input->post('nama_voucher');
        $harga = $this->input->post('harga');
        $jumlah = $this->input->post('jumlah');
        $amount_total = $jumlah * $harga;

        Xendit::setApiKey('xnd_development_k5NhSKGE5HMGpywJP7TzloUuEVPxBYdjcRWtJSWs3fTcyJgExLhmg2XUjrxJy8T');

        $params = [
            'external_id' => $external_id,
            'amount' => $amount_total,
            'description' => $keterangan,
            'invoice_duration' => 86400,
            'customer' => [
                'given_names' => $nama_customer,
                'email' => $email,
                'mobile_number' => '08978201075',
                'addresses' => [
                    [
                        'city' => 'Jakarta Selatan',
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
            'items' => [
                [
                    'name' => $nama_voucher,
                    'quantity' => $jumlah,
                    'price' => $harga,
                    'url' => 'https=>//yourcompany.com/example_item'
                ]
            ],
            'fees' => [
                [
                    'type' => 'ADMIN',
                    'value' => 5000
                ]
            ]
        ];

        $createInvoice = \Xendit\Invoice::create($params);
        var_dump($createInvoice);
    }
}
