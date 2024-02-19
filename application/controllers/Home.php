<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Home_model');
        $this->load->model('About_model');
        $this->load->model('Service_model');
        $this->load->model('Slider_model');
        $this->load->model('Riview_model');
        $this->load->model('Contact_model');
        $this->load->model('Product_model');
    }
    public function index()
    {
        $this->load->view('landing/index');
    }
}
