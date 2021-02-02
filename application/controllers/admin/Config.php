<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Config extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
		$this->load->model('M_config', 'm_config');

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

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		$input = array('thn_dok', 'unit_group');
		foreach ($input as $val) {
			if (input($val) == '') {
				$data['inputerror'][] = $val;
				$data['error'][] = 'Bagian ini harus diisi';
				$data['status'] = false;
			}
		}

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function upd_stat()
	{
		$this->db->update('tbl_config', ['status' => 0]);
		$this->m_config->update(['status' => 1], ['no' => input('id')]);
	}

	public function index()
	{
		$page = 'admin/v_config';
		$data['title'] = 'Website Config';
		$qry = 'SELECT * FROM tbl_unit WHERE nm_unit LIKE \'%group%\'';
		$data['unit'] = $this->db->query($qry)->result_array();
		$data['data'] = $this->m_config->show();

		$this->load->view($page, $data);
	}

	public function insert()
	{
		$this->validasi();

		$data = array(
			'thn_dokumen' => input('thn_dok'),
			'nm_group' => input('unit_group')
		);
		$this->m_config->create($data);

		echo json_encode(['status' => true]); exit;
	}

	public function update()
	{
		$this->validasi();

		$key['no'] = input('id_config');
		$data = array(
			'thn_dokumen' => input('thn_dok'),
			'nm_group' => input('unit_group')
		);
		$this->m_config->update($data, $key);

		$title = 'Berhasil';
		$text = 'Nama pegawai berhasil tersimpan';
		$icon = 'success';

		echo json_encode(['status' => true]);
		exit;
	}

	public function get_data($id)
	{
		$key['no'] = $id;
		$data = $this->m_config->read($key)->row_array();
		echo json_encode($data);
		exit;
	}

	public function delete($id)
	{
		$key['no'] = $id;
		$cek = $this->db->get('tbl_config')->num_rows();
		if($cek > 1){
			$this->m_config->delete($key);
			
			echo json_encode(['status' => true]);
			exit;
		} else {
			echo json_encode(['status' => false]);
			exit;
		}

	}
}
