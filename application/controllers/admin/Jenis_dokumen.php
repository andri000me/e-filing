<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_dokumen extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
		$this->load->model('M_jenis_dokumen', 'm_jns_dokumen');

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
		$page = 'admin/v_jenis_dokumen';
		$data['title'] = 'Data Master Jenis Dokumen';
		$data['data'] = $this->m_jns_dokumen->show();

		$this->load->view($page, $data);
	}

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		if (input('jns_dokumen') == '') {
			$data['inputerror'][] = 'jns_dokumen';
			$data['error'][] = 'Jenis dokumen harus diisi';
			$data['status'] = false;
		} else if (!preg_match('/^[a-zA-Z ]+$/', input('jns_dokumen'))) {
			$data['inputerror'][] = 'jns_dokumen';
			$data['error'][] = 'Jenis dokumen tidak valid, haruf huruf alphabet';
			$data['status'] = false;
		}

		if (input('ket_dokumen') == '') {
			$data['inputerror'][] = 'ket_dokumen';
			$data['error'][] = 'Keterangan dokumen harus diisi';
			$data['status'] = false;
		} else if (!preg_match('/^[a-zA-Z ]+$/', input('ket_dokumen'))) {
			$data['inputerror'][] = 'ket_dokumen';
			$data['error'][] = 'Keterangan dokumen tidak valid, haruf huruf alphabet';
			$data['status'] = false;
		}

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function get_data($id)
	{
		$key['id_jns_dokumen'] = $id;
		$data = $this->m_jns_dokumen->read($key)->row_array();
		echo json_encode($data); exit;
	}

	public function insert()
	{
		$this->validasi();

		$data = array(
			'jns_dokumen' => input('jns_dokumen'),
			'keterangan' => input('ket_dokumen')
		);
		$this->m_jns_dokumen->create($data);

		echo json_encode(['status' => true]);
		exit;
	}

	public function update()
	{
		$this->validasi();

		$key['id_jns_dokumen'] = input('id_dokumen');
		$data = array(
			'jns_dokumen' => input('jns_dokumen'),
			'keterangan' => input('ket_dokumen')
		);
		$this->m_jns_dokumen->update($data, $key);

		echo json_encode(['status' => true]);
		exit;
	}

	public function delete($id)
	{
		$key['id_jns_dokumen'] = $id;
		$this->m_jns_dokumen->delete($key);

		echo json_encode(['status' => true]);
		exit;
	}
}
