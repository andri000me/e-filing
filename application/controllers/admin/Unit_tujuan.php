<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Unit_tujuan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
		$this->load->model('M_unit_tujuan', 'm_unit');

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
		$page = 'admin/v_unit_tujuan';

		$data['title'] = 'Data Master Unit Tujuan';

		$this->load->view($page, $data);
	}

	public function list_unit()
	{
		$list = $this->m_unit->get_datatables();
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $li) {
			$row = array();
			$row[] = '<center>' . number_format($no++) . '</center>';
			$row[] = $li['kd_unit'];
			$row[] = $li['nm_unit'];
			$aksi = '<center>';
			$aksi .= '<span class="badge badge-success" style="cursor: pointer" onclick="sunting(\'' . $li['no'] . '\')"><i class="fa fa-edit"></i></span>&nbsp';
			$aksi .= '<span class="badge badge-danger" style="cursor: pointer" onclick="hapus(\'' . $li['no'] . '\')"><i class="fa fa-trash"></i></span>';
			$aksi .= '</center>';
			$row[] = $aksi;

			$data[] = $row;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->m_unit->get_all_data(),
			'recordsFiltered' => $this->m_unit->count_filtered(),
			'data' => $data
		);
		echo json_encode($output);
		exit();
	}

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		if (input('kd_unit') == '') {
			$data['inputerror'][] = 'kd_unit';
			$data['error'][] = 'Kode unit harus diisi';
			$data['status'] = false;
		} else if (!preg_match('/^[A-Z0-9 ]+$/', strtoupper(input('kd_unit')))) {
			$data['inputerror'][] = 'kd_unit';
			$data['error'][] = 'Kode unit tidak valid';
			$data['status'] = false;
		}

		if (input('nm_unit') == '') {
			$data['inputerror'][] = 'nm_unit';
			$data['error'][] = 'Nama unit harus diisi';
			$data['status'] = false;
		} 
		// else if (!preg_match('/^[A-Z0-9, ]+$/', strtoupper(input('nm_unit')))) {
		// 	$data['inputerror'][] = 'nm_unit';
		// 	$data['error'][] = 'Nama unit tidak sesuai format';
		// 	$data['status'] = false;
		// }

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function get_data($id)
	{
		$key['no'] = $id;
		$data = $this->m_unit->read($key)->row_array();

		$respon = array(
			'no' => $data['no'],
			'kd_unit' => $data['kd_unit'],
			'nm_unit' => strtoupper(reverse($data['nm_unit']))
		);
		echo json_encode($respon);
		exit;
	}

	public function insert()
	{
		$this->validasi();

		$title = '';
		$text = '';
		$icon = '';
		$where = "kd_unit like '%" . strtoupper(input('kd_unit')) . "%' or nm_unit like '%" . strtoupper(input('nm_unit')) . "%'";

		$cek = $this->db->get_where('tbl_unit', $where)->num_rows();
		if ($cek > 0) {
			$title = 'Oops!';
			$text = 'Unit tujuan sudah ada';
			$icon = 'warning';
		} else {
			$title = 'Berhasil';
			$text = 'Unit tujuan berhasil tersimpan';
			$icon = 'success';

			$data = array(
				'kd_unit' => strtoupper(input('kd_unit')),
				'nm_unit' => strtoupper(input('nm_unit'))
			);
			$this->m_unit->create($data);
		}

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function update()
	{
		$this->validasi();

		$title = 'Berhasil';
		$text = 'Unit tujuan berhasil tersimpan';
		$icon = 'success';

		$key['no'] = input('no');
		$data = array(
			'kd_unit' => strtoupper(input('kd_unit')),
			'nm_unit' => strtoupper(input('nm_unit'))
		);
		$this->m_unit->update($data, $key);

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function delete($id)
	{
		$key['no'] = $id;
		$this->m_unit->delete($key);

		echo json_encode(['status' => true]);
		exit;
	}
}
