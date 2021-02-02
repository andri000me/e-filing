<?php
defined('BASEPATH') or exit('No direct script access allowed');

class pegawai extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
		$this->load->model('M_pegawai', 'm_pegawai');
		$this->load->model('M_jabatan', 'm_jabatan');

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
		$page = 'admin/v_pegawai';
		$data['title'] = 'Data Master pegawai';
		$data['data'] = $this->m_pegawai->show();
		$data['li_jabatan'] = $this->m_jabatan->show();

		$this->load->view($page, $data);
	}

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		if (input('nm_pegawai') == '') {
			$data['inputerror'][] = 'nm_pegawai';
			$data['error'][] = 'Nama pegawai harus diisi';
			$data['status'] = false;
		} else if (!preg_match('/^[a-zA-Z ]+$/', input('nm_pegawai'))) {
			$data['inputerror'][] = 'nm_pegawai';
			$data['error'][] = 'Nama pegawai tidak valid, haruf huruf alphabet';
			$data['status'] = false;
		}

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function get_data($id)
	{
		$key['id_pegawai'] = $id;
		$data = $this->m_pegawai->read($key)->row_array();
		echo json_encode($data);
		exit;
	}

	public function insert()
	{
		$this->validasi();

		$data = array(
			'nm_pegawai' => input('nm_pegawai'),
			'id_jabatan' => input('li_jabatan')
		);
		$this->m_pegawai->create($data);

		echo json_encode(['status' => true]);
		exit;
	}

	public function update()
	{
		$this->validasi();

		$key['id_pegawai'] = input('id_pegawai');
		$data = array(
			'nm_pegawai' => input('nm_pegawai'),
			'id_jabatan' => input('li_jabatan')
		);
		$this->m_pegawai->update($data, $key);

		$title = 'Berhasil';
		$text = 'Nama pegawai berhasil tersimpan';
		$icon = 'success';

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function delete($id)
	{
		$key['id_pegawai'] = $id;
		$this->m_pegawai->delete($key);

		echo json_encode(['status' => true]);
		exit;
	}
}
