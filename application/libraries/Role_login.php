<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Jakarta");

class Role_login
{
	protected $ci;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->model('Auth_model');
		$this->ci->load->model('Paket/Paket_model');
		$this->ci->load->helper('string');
	}

	public function login($username, $password)
	{
		$cek = $this->ci->Auth_model->login($username);
		if ($cek) {
			if ($cek && password_verify($password, $cek->password)) {
				$username = $cek->username;
				$email = $cek->email;
				$id_user = $cek->id_user;
				$id_role = $cek->id_role;
				$this->ci->session->set_userdata('username', $username);
				$this->ci->session->set_userdata('id_user', $id_user);
				$this->ci->session->set_userdata('email', $email);
				$this->ci->session->set_userdata('id_role', $id_role);
				if ($this->ci->session->userdata('id_role')) {
					redirect('dashboard');
				} else {
					$this->ci->session->unset_userdata('username');
					$this->ci->session->unset_userdata('id_role');
					$this->ci->session->unset_userdata('id_user');
					$this->ci->session->unset_userdata('email');
					$this->ci->session->set_flashdata('tidak_bisa', 'Anda Tidak Diperkenankan untuk login di aplikasi ini');
					redirect('auth');
				}
			} else {
				$this->ci->session->set_flashdata('salah', 'Username Atau Password Salah');
				redirect('auth');
			}
		} else {
			$this->ci->session->set_flashdata('salah', 'Username Tidak Terdaftar');
			redirect('auth');
		}
	}
	public function cek_login()
	{
		if ($this->ci->session->userdata('username') == "") {
			$this->ci->session->set_flashdata('pesan', 'Anda Belom Login !!!');
			redirect('auth');
		}
	}
	public function logout()
	{
		$this->ci->session->unset_userdata('username');
		$this->ci->session->unset_userdata('email');
		$this->ci->session->unset_userdata('id_user');
		$this->ci->session->unset_userdata('id_role');
		$this->ci->session->set_flashdata('berhasil', 'Anda Berhasil Logout');
		redirect('landing');
	}
}
