<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');

		$is_login = $this->session->userdata('is_login');

		if ($is_login === true) {
			$cek_role = $this->m_login->get_user($this->session->userdata('username'));
			if ($cek_role['lv_user'] != $this->uri->segment('1')) {
				session_destroy();
				redirect(base_url());
			}
		} else {
			session_destroy();
			redirect(base_url());
		}
	}

	public function index()
	{
		$page = 'v_dashboard';
		$data['title'] = 'Dashboard';
		$data['dok_masuk'] = $this->db->get('tbl_dok_masuk')->num_rows();
		$data['disposisi'] = $this->db->get_where('tbl_dok_masuk', ['tgl_disposisi !=' => null])->num_rows();
		$data['dok_keluar'] = $this->db->get('tbl_dok_keluar')->num_rows();
		$data['pegawai'] = $this->db->get('tbl_pegawai')->num_rows();

		$this->load->view($page, $data);
	}
}
