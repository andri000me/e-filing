<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori_dokumen extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
		$this->load->model('M_kategori', 'm_kategori');

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
		$page = 'admin/v_kategori_dokumen';
		$data['title'] = 'Data Master Kategori Dokumen';
		$data['data'] = $this->m_kategori->show();

		$this->load->view($page, $data);
	}

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		$arr = array('jns_kategori', 'ket_kategori');
		foreach ($arr as $val) {
			if(input($val) == ''){
				$data['inputerror'][] = $val;
				$data['error'][] = 'Bagian ini harus diisi';
				$data['status'] = false;
			}
		}

		// if (input('jns_kategori') == '') {
		// 	$data['inputerror'][] = 'jns_kategori';
		// 	$data['error'][] = 'Jenis kategori harus diisi';
		// 	$data['status'] = false;
		// } else if (!preg_match('/^[a-zA-Z ]+$/', input('jns_kategori'))) {
		// 	$data['inputerror'][] = 'jns_kategori';
		// 	$data['error'][] = 'Jenis kategori tidak valid, haruf huruf alphabet';
		// 	$data['status'] = false;
		// }

		// if (input('ket_kategori') == '') {
		// 	$data['inputerror'][] = 'ket_kategori';
		// 	$data['error'][] = 'Keterangan kategori harus diisi';
		// 	$data['status'] = false;
		// } else if (!preg_match('/^[a-zA-Z ]+$/', input('ket_kategori'))) {
		// 	$data['inputerror'][] = 'ket_kategori';
		// 	$data['error'][] = 'Keterangan kategori tidak valid, haruf huruf alphabet';
		// 	$data['status'] = false;
		// }

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function get_data($id)
	{
		$key['id_kategori'] = $id;
		$data = $this->m_kategori->read($key)->row_array();

		$respon = array(
			'id_kategori' => $data['id_kategori'],
			'jns_kategori' => html_entity_decode($data['jns_kategori'], ENT_QUOTES, 'UTF-8'),
			'keterangan' => html_entity_decode($data['keterangan'], ENT_QUOTES, 'UTF-8')
		);
		echo json_encode($respon); exit;
	}

	public function insert()
	{
		$this->validasi();

		$data = array(
			'jns_kategori' => input('jns_kategori'),
			'keterangan' => input('ket_kategori')
		);
		$this->m_kategori->create($data);

		echo json_encode(['status' => true]);
		exit;
	}

	public function update()
	{
		$this->validasi();

		$key['id_kategori'] = input('id_kategori');
		$data = array(
			'jns_kategori' => input('jns_kategori'),
			'keterangan' => input('ket_kategori')
		);
		$this->m_kategori->update($data, $key);

		echo json_encode(['status' => true]);
		exit;
	}

	public function delete($id)
	{
		$key['id_kategori'] = $id;
		$this->m_kategori->delete($key);

		echo json_encode(['status' => true]);
		exit;
	}
}
