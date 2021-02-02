<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
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
		$page = 'admin/v_jabatan';
		$data['title'] = 'Data Master Jabatan';
		$data['data'] = $this->m_jabatan->show();

		$this->load->view($page, $data);
	}

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		if (input('nm_jabatan') == '') {
			$data['inputerror'][] = 'nm_jabatan';
			$data['error'][] = 'Nama jabatan harus diisi';
			$data['status'] = false;
		} else if (!preg_match('/^[a-zA-Z ]+$/', input('nm_jabatan'))) {
			$data['inputerror'][] = 'nm_jabatan';
			$data['error'][] = 'Nama jabatan tidak valid, haruf huruf alphabet';
			$data['status'] = false;
		}

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function get_data($id)
	{
		$key['id_jabatan'] = $id;
		$data = $this->m_jabatan->read($key)->row_array();
		echo json_encode($data); exit;
	}

	public function insert()
	{
		$this->validasi();

		$title = '';
		$text = '';
		$icon = '';
		$where = "nm_jabatan like '%" . input('nm_jabatan') . "%'";

		$cek = $this->db->get_where('tbl_jabatan', $where)->num_rows();
		if ($cek > 0) {
			$title = 'Oops!';
			$text = 'Nama jabatan sudah ada';
			$icon = 'warning';
		} else {
			$title = 'Berhasil';
			$text = 'Nama jabatan berhasil tersimpan';
			$icon = 'success';

			$data = array(
				'nm_jabatan' => input('nm_jabatan')
			);
			$this->m_jabatan->create($data);
		}

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function update()
	{
		$this->validasi();

		$key['id_jabatan'] = input('id_jabatan');
		$data = array(
			'nm_jabatan' => input('nm_jabatan')
		);
		$this->m_jabatan->update($data, $key);

		$title = 'Berhasil';
		$text = 'Nama jabatan berhasil tersimpan';
		$icon = 'success';

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function delete($id)
	{
		$key['id_jabatan'] = $id;
		$this->m_jabatan->delete($key);

		echo json_encode(['status' => true]);
		exit;
	}
}
