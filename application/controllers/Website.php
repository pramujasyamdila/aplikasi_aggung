<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Website extends CI_Controller
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
        $this->load->model('Friendly_model');


        $this->load->helper(array('url', 'form'));
        $this->load->library(array('form_validation', 'recaptcha'));
    }
    function index()
    {
        $data['title'] = 'Home';
        $data['homes'] = $this->Home_model->get_homes();
        $data['homex'] = $this->Home_model->get_text_homes();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/home', $data);
        $this->load->view('template/footer');
    }


    //edit
    public function edit_home_text($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['homex'] = $this->Home_model->get_text_home($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_home_text', $data);
        $this->load->view('template/footer');
    }

    public function update_home_text($id)
    {
        $data = array(
            'judul' => $this->input->post('judul'),
            'sub_judul' => $this->input->post('sub_judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tgl_update' => date('Y-m-d H:i:s')

        );

        $this->Home_model->update_text_home($id, $data);
        redirect('website/index');
    }

    //create
    public function create()
    {
        $data['title'] = 'Form Create Data';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/create_home', $data);
        $this->load->view('template/footer');
    }

    // delete home
    public function delete($id)
    {
        $this->Home_model->delete_home($id);
        redirect('website/index');
    }
    //edit
    public function edit($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['home'] = $this->Home_model->get_home($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_home', $data);
        $this->load->view('template/footer');
    }
    //update

    public function update($id)

    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

        $data['title'] = 'Form Edit Data';

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/edit_home', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/home/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/edit_home', $error);
                $this->load->view('template/footer');
            } else {


                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_update' => date('Y-m-d H:i:s')

                );

                $this->Home_model->update_home($id, $data);
                redirect('website/index');
            }
        }
    }

    // simpan
    public function store()
    {
        $data['title'] = 'Form Create Data';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/create_home', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/home/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/create_home', $error);
                $this->load->view('template/footer');
            } else {
                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_dibuat' => date('Y-m-d H:i:s')
                );

                $this->Home_model->create_home($data);
                redirect('website/index');
            }
        }
    }

    //about index
    function about()
    {
        $data['title'] = 'About';
        $data['about'] = $this->About_model->get_abouts();
        $data['text'] = $this->About_model->get_abouts_text();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/about', $data);
        $this->load->view('template/footer');
    }

    //create
    public function create_about()
    {
        $data['title'] = 'Form Create Data';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/create_about', $data);
        $this->load->view('template/footer');
    }

    //edit
    public function edit_about($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['about'] = $this->About_model->get_about($id);
        // $data['about_text'] = $this->About_model->get_about_text($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_about', $data);
        $this->load->view('template/footer');
    }

    public function update_about($id)

    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

        $data['title'] = 'Form Edit Data';

        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/edit_about', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/about/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/edit_about', $error);
                $this->load->view('template/footer');
            } else {


                $data = array(
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_update' => date('Y-m-d H:i:s')

                );

                $this->About_model->update_about($id, $data);
                redirect('website/about');
            }
        }
    }

    // simpan
    public function about_post()
    {
        $data['title'] = 'Form Create Data';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/create_about', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/about/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/create_about', $error);
                $this->load->view('template/footer');
            } else {
                $data = array(
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_dibuat' => date('Y-m-d H:i:s')
                );

                $this->About_model->create_about($data);
                redirect('website/about');
            }
        }
    }

    //edit
    public function edit_about_text($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['about_text'] = $this->About_model->get_about_text($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_about_text', $data);
        $this->load->view('template/footer');
    }

    public function update_about_text($id)
    {
        $data = array(
            'judul' => $this->input->post('judul'),
            'sub_judul' => $this->input->post('sub_judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tgl_update' => date('Y-m-d H:i:s')

        );

        $this->About_model->update_about_text($id, $data);
        redirect('website/about');
    }

    // delete home
    public function delete_about($id)
    {
        $this->About_model->delete_about($id);
        redirect('website/about');
    }


    //about Service
    function service()
    {
        $data['title'] = 'Service';
        $data['service'] = $this->Service_model->get_services();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/service', $data);
        $this->load->view('template/footer');
    }

    //create
    public function create_service()
    {
        $data['title'] = 'Form Create Data';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/create_service', $data);
        $this->load->view('template/footer');
    }

    public function update_service($id)

    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

        $data['title'] = 'Form Edit Data';

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/edit_service', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/service/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 0; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/edit_service', $error);
                $this->load->view('template/footer');
            } else {


                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_update' => date('Y-m-d H:i:s')

                );

                $this->Service_model->update($id, $data);
                redirect('website/service');
            }
        }
    }

    // simpan
    public function store_service()
    {
        $data['title'] = 'Form Create Data';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/create_service', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/service/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 0; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/create_service', $error);
                $this->load->view('template/footer');
            } else {
                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_dibuat' => date('Y-m-d H:i:s')
                );

                $this->Service_model->create_service($data);
                redirect('website/service');
            }
        }
    }



    // delete home
    public function delete_service($id)
    {
        $this->Service_model->delete($id);
        redirect('website/service');
    }

    //about Service
    function slider_price()
    {
        $data['title'] = 'Service';
        $data['slider'] = $this->Slider_model->get_sliders();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/slider_price', $data);
        $this->load->view('template/footer');
    }

    //create
    public function create_slider_price()
    {
        $data['title'] = 'Form Create Data';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/create_slider_price', $data);
        $this->load->view('template/footer');
    }


    // simpan
    public function store_slider_price()
    {
        $data['title'] = 'Form Create Data';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/create_slider_price', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/slider_price/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/create_slider_price', $error);
                $this->load->view('template/footer');
            } else {
                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_dibuat' => date('Y-m-d H:i:s')
                );

                $this->Slider_model->create_slider_price($data);
                redirect('website/slider_price');
            }
        }
    }

    //edit
    public function edit_slider_price($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['edit_sp'] = $this->Slider_model->get_slider($id);
        // $data['about_text'] = $this->About_model->get_about_text($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_slider_price', $data);
        $this->load->view('template/footer');
    }


    
    // delete 
    public function delete_slider_price($id)
    {
        $this->Slider_model->delete($id);
        redirect('website/slider_price');
    }

    public function update_slider_price($id)

    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

        $data['title'] = 'Form Edit Data';

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/edit_slider_price', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/slider_price/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 0; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/edit_slider_price', $error);
                $this->load->view('template/footer');
            } else {


                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_update' => date('Y-m-d H:i:s')

                );

                $this->Slider_model->update_slider($id, $data);
                redirect('website/slider_price');
            }
        }
    }
    //edit
    public function edit_service($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['service'] = $this->Service_model->get_service($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_service', $data);
        $this->load->view('template/footer');
    }
    public function update_riview($id)

    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

        $data['title'] = 'Form Edit Data';

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/edit_riview', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/riview/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 0; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/edit_riview', $error);
                $this->load->view('template/footer');
            } else {


                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_update' => date('Y-m-d H:i:s')

                );

                $this->Riview_model->update_riview($id, $data);
                redirect('website/riview');
            }
        }
    }
    //about Service
    function riview()
    {
        $data['title'] = 'riview';
        $data['riview'] = $this->Riview_model->get_riviews();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/riview', $data);
        $this->load->view('template/footer');
    }
    //edit
    public function edit_riview($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['riview'] = $this->Riview_model->get_riview($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_riview', $data);
        $this->load->view('template/footer');
    }



    //create
    public function create_riview()
    {
        $data['title'] = 'Form Create Data';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/create_riview', $data);
        $this->load->view('template/footer');
    }

    // simpan
    public function store_riview()
    {
        $data['title'] = 'Form Create Data';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/create_riview', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/riview/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/create_riview', $error);
                $this->load->view('template/footer');
            } else {
                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_dibuat' => date('Y-m-d H:i:s')
                );

                $this->Riview_model->create_riview($data);
                redirect('website/riview');
            }
        }
    }

    // delete home
    public function delete_riview($id)
    {
        $this->Riview_model->delete($id);
        redirect('website/riview');
    }

    //about contact
    function contact()
    {
        $data['title'] = 'contact';
        $data['contact'] = $this->Contact_model->get_contacts();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/contact', $data);
        $this->load->view('template/footer');
    }

    //edit
    public function edit_contact($id)
    {
        $data['title'] = 'Form Edit Data';
        $data['contact'] = $this->Contact_model->get_contact($id);
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/edit_contact', $data);
        $this->load->view('template/footer');
    }

    //update

    public function update_contact($id)

    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));

        $data['title'] = 'Form Edit Data';

        $this->form_validation->set_rules('perusahaan', 'perusahaan', 'trim');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim');
        $this->form_validation->set_rules('no_telp', 'no_telp', 'trim');
        $this->form_validation->set_rules('jam_operasional', 'jam_operasional', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/edit_contact', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/contact/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/edit_contact', $error);
                $this->load->view('template/footer');
            } else {


                $data = array(
                    'perusahaan' => $this->input->post('perusahaan'),
                    'alamat' => $this->input->post('alamat'),
                    'no_telp' => $this->input->post('no_telp'),
                    'jam_operasional' => $this->input->post('jam_operasional'),
                    'email' => $this->input->post('email'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_update' => date('Y-m-d H:i:s')

                );

                $this->Contact_model->update_contact($id, $data);
                redirect('website/contact');
            }
        }
    }

    //about Service
    function product()
    {
        $data['title'] = 'Product';
        $data['product'] = $this->Product_model->get_products();

        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/product', $data);
        $this->load->view('template/footer');
    }

     //edit
     public function edit_product($id)
     {
         $data['title'] = 'Form Edit Data';
         $data['product'] = $this->Product_model->get_product($id);
         $this->load->view('template/header', $data);
         $this->load->view('template/navbar');
         $this->load->view('template/sidebar');
         $this->load->view('website/edit_product', $data);
         $this->load->view('template/footer');
     }
     public function update_product($id)
 
     {
         error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));
 
         $data['title'] = 'Form Edit Data';
 
         $this->form_validation->set_rules('judul', 'Judul', 'trim');
         $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
         $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
         $this->form_validation->set_rules('status', 'Status', 'required');
         $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
 
         if ($this->form_validation->run() === FALSE) {
             // Validasi gagal, kembali ke form dengan pesan kesalahan
             $this->load->view('template/header', $data);
             $this->load->view('template/navbar');
             $this->load->view('template/sidebar');
             $this->load->view('website/edit_product', $data);
             $this->load->view('template/footer');
         } else {
             $config['upload_path'] = './assets/product/';
             $config['allowed_types'] = 'jpg|jpeg|png|gif';
             $config['max_size'] = 0; // Batasan ukuran gambar (2MB)
 
             $this->load->library('upload', $config);
 
             if (!$this->upload->do_upload('gambar')) {
                 // Upload gagal, tampilkan pesan kesalahan
                 $error = array('error' => $this->upload->display_errors());
                 $this->load->view('template/header', $data);
                 $this->load->view('template/navbar');
                 $this->load->view('template/sidebar');
                 $this->load->view('website/edit_product', $error);
                 $this->load->view('template/footer');
             } else {
 
 
                 $data = array(
                     'judul' => $this->input->post('judul'),
                     'sub_judul' => $this->input->post('sub_judul'),
                     'deskripsi' => $this->input->post('deskripsi'),
                     'status' => $this->input->post('status'),
                     'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                     'tgl_update' => date('Y-m-d H:i:s')
 
                 );
 
                 $this->Product_model->update_product($id, $data);
                 redirect('website/product');
             }
         }
     }

    //create
    public function create_product()
    {
        $data['title'] = 'Form Create Data';
        $this->load->view('template/header', $data);
        $this->load->view('template/navbar');
        $this->load->view('template/sidebar');
        $this->load->view('website/create_product', $data);
        $this->load->view('template/footer');
    }

    // simpan
    public function store_product()
    {
        $data['title'] = 'Form Create Data';
        $this->load->library('form_validation');

        $this->form_validation->set_rules('judul', 'Judul', 'trim');
        $this->form_validation->set_rules('sub_judul', 'Sub Judul', 'trim');
        $this->form_validation->set_rules('deskripsi', 'Deskripsi', 'trim');
        $this->form_validation->set_rules('status', 'Status', 'required');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            // Validasi gagal, kembali ke form dengan pesan kesalahan
            $this->load->view('template/header', $data);
            $this->load->view('template/navbar');
            $this->load->view('template/sidebar');
            $this->load->view('website/create_product', $data);
            $this->load->view('template/footer');
        } else {
            $config['upload_path'] = './assets/product/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 2048; // Batasan ukuran gambar (2MB)

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('gambar')) {
                // Upload gagal, tampilkan pesan kesalahan
                $error = array('error' => $this->upload->display_errors());
                $this->load->view('template/header', $data);
                $this->load->view('template/navbar');
                $this->load->view('template/sidebar');
                $this->load->view('website/create_product', $error);
                $this->load->view('template/footer');
            } else {
                $data = array(
                    'judul' => $this->input->post('judul'),
                    'sub_judul' => $this->input->post('sub_judul'),
                    'deskripsi' => $this->input->post('deskripsi'),
                    'status' => $this->input->post('status'),
                    'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                    'tgl_dibuat' => date('Y-m-d H:i:s')
                );

                $this->Product_model->create_product($data);
                redirect('website/product');
            }
        }
    }

    // delete home
    public function delete_product($id)
    {
        $this->Product_model->delete($id);
        redirect('website/product');
    }


     // friendly
     function friendly()
     {
         $data['title'] = 'Friendly';
         $data['friendly'] = $this->Friendly_model->get_friendlys();
         $data['friendly_image'] = $this->Friendly_model->get_friendly_images();

         $this->load->view('template/header', $data);
         $this->load->view('template/navbar');
         $this->load->view('template/sidebar');
         $this->load->view('website/friendly', $data);
         $this->load->view('template/footer');
     }

     //edit
     public function edit_friendly($id)
     {
         $data['title'] = 'Form Edit Data';
         $data['friendly'] = $this->Friendly_model->get_friendly($id);
         $this->load->view('template/header', $data);
         $this->load->view('template/navbar');
         $this->load->view('template/sidebar');
         $this->load->view('website/edit_friendly', $data);
         $this->load->view('template/footer');
     }

     public function update_friendly($id)
    {
        $data = array(
            'judul' => $this->input->post('judul'),
            'sub_judul' => $this->input->post('sub_judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tgl_update' => date('Y-m-d H:i:s')

        );

        $this->Friendly_model->update($id, $data);
        redirect('website/friendly');
    }


     //create 
     public function create_friendly_image()
     {
         $data['title'] = 'Form Create Data';
         $this->load->view('template/header', $data);
         $this->load->view('template/navbar');
         $this->load->view('template/sidebar');
         $this->load->view('website/create_friendly_image', $data);
         $this->load->view('template/footer');
     }
 
 // simpan
 public function friendly_image_post()
 {
     $data['title'] = 'Form Create Data';
     $this->load->library('form_validation');

     $this->form_validation->set_rules('status', 'Status', 'required');
     $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

     if ($this->form_validation->run() === FALSE) {
         // Validasi gagal, kembali ke form dengan pesan kesalahan
         $this->load->view('template/header', $data);
         $this->load->view('template/navbar');
         $this->load->view('template/sidebar');
         $this->load->view('website/create_friendly_image', $data);
         $this->load->view('template/footer');
     } else {
         $config['upload_path'] = './assets/create_friendly_image/';
         $config['allowed_types'] = 'jpg|jpeg|png|gif';
         $config['max_size'] = 0; // Batasan ukuran gambar (2MB)

         $this->load->library('upload', $config);

         if (!$this->upload->do_upload('gambar')) {
             // Upload gagal, tampilkan pesan kesalahan
             $error = array('error' => $this->upload->display_errors());
             $this->load->view('template/header', $data);
             $this->load->view('template/navbar');
             $this->load->view('template/sidebar');
             $this->load->view('website/create_friendly_image', $error);
             $this->load->view('template/footer');
         } else {
             $data = array(
                 'status' => $this->input->post('status'),
                 'gambar' => $this->upload->data('file_name'), // Nama gambar yang diupload
                 'tgl_dibuat' => date('Y-m-d H:i:s')
             );

             $this->Friendly_model->create_friendly_image($data);
             redirect('website/friendly');
         }
     }
 }

 // delete delete_friendly_image
 public function delete_friendly_image($id)
 {
     $this->Friendly_model->delete($id);
     redirect('website/friendly');
 }

}
