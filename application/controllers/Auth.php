<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
	}

	public function index()
	{
		$data['page'] = 'v_login';

		$this->load->view('v_login');
	}

	public function login()
	{
		$username = input('username');
		$password = md5(input('password'));

		$check = $this->m_login->login($username, $password);
		if ($check > 0) {
			$user = $this->m_login->get_user($username);
			$sess = array(
				'username' => $user['username'],
				'nama_user' => $user['nm_user'],
				'lv_user' => $user['lv_user'],
				'is_login' => true
			);

			$this->session->set_userdata($sess);
			redirect(site_url($user['lv_user'] . '/page/dashboard'));
		} else {
			$this->session->set_flashdata('msg', 'Username atau Password tidak sesuai');
			$this->index();
		}
	}

	public function logout()
	{
		session_destroy();
		redirect(base_url());
	}
}
