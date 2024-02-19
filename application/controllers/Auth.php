<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('url', 'form'));
		$this->load->model('Paket/Paket_model');
		$this->load->model('Auth_model');
		$this->load->library(array('form_validation', 'recaptcha'));
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$recaptcha = $this->input->post('g-recaptcha-response');
		if (!empty($recaptcha)) {
			$response = $this->recaptcha->verifyResponse($recaptcha);
			if (isset($response['success']) and $response['success'] === true) {
				if ($this->form_validation->run() == false) {
					$data['title'] = 'LOGIN';
					$this->load->view('auth/v_login', $data);
					$this->load->view('auth/ajax', $data);
					$this->session->set_flashdata('salah', 'Username Atau Password Salah');
					redirect('auth');
				} else {
					$username = $this->input->post('username');
					$password = $this->input->post('password');
					// $qrcode = random_string('numeric', 4);
					$this->role_login->login($username, $password);
				}
			}
		}
		$data['widget'] = $this->recaptcha->getWidget();
		$data['script'] = $this->recaptcha->getScriptTag();
		$this->load->view('auth/v_login', $data);
	}

	public function logout()
	{
		$this->role_login->logout();
	}
}
