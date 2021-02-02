<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dokumen_keluar extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login', 'm_login');
		$this->load->model('M_dokumen_keluar', 'm_dok_keluar');
		$this->load->model('M_jenis_dokumen', 'm_jns_dokumen');
		$this->load->model('M_kategori', 'm_kategori');
		$this->load->model('M_unit_tujuan', 'm_tujuan');
		$this->load->model('M_pegawai', 'm_pegawai');
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

	public function index()
	{
		$page = 'user/v_dokumen_keluar';
		$group = $this->m_config->read(['status' => 1])->row_array();

		$data['title'] = 'Dokumen Keluar';
		$data['jns_dokumen'] = $this->m_jns_dokumen->show();
		$data['kategori'] = $this->m_kategori->show();
		$qry = 'SELECT * FROM tbl_unit WHERE kd_unit != \'' . $group['nm_group'] . '\' ORDER BY CASE WHEN nm_unit LIKE \'%group%\' THEN 1 ELSE 2 END';
		$data['tujuan'] = $this->db->query($qry)->result_array();
		$data['pembuat'] = $this->m_pegawai->show();

		$this->load->view($page, $data);
	}

	public function validasi()
	{
		$data = array();
		$data['inputerror'] = array();
		$data['error'] = array();
		$data['status'] = true;

		// var_dump($_POST); die;

		$post = array(
			'jns_dokumen', 'perihal', 'pembuat', 'kategori', 'sts_dokumen'
		);

		foreach ($post as $post) {
			if (input($post) == '') {
				$data['inputerror'][] = $post;
				$data['error'][] = 'Bagian ini harus diisi';
				$data['status'] = false;
			}
		}

		if (input('jns_dokumen') != 3) {
			if (!isset($_POST['li_tujuan'])) {
				$data['inputerror'][] = 'li_tujuan';
				$data['error'][] = 'Bagian ini harus diisi';
				$data['status'] = false;
			}
		} else {
			if (input('tujuan_lain') == '') {
				$data['inputerror'][] = 'tujuan_lain';
				$data['error'][] = 'Bagian ini harus diisi';
				$data['status'] = false;
			}
		}


		// if (!isset($_POST['li_tujuan'])) {
		// 	$data['inputerror'][] = 'li_tujuan';
		// 	$data['error'][] = 'Bagian ini harus diisi';
		// 	$data['status'] = false;
		// }

		if ($data['status'] === false) {
			echo json_encode($data);
			exit();
		}
	}

	public function get_list()
	{
		$list = $this->m_dok_keluar->get_datatables();
		$data = array();
		$no = $_POST['start'] + 1;
		foreach ($list as $li) {
			$row = array();
			$row[] = '<center>' . $no++ . '</center>';

			$jns_dokumen = $li['jns_dokumen'] . '<br>';
			$jns_dokumen .= $li['jns_kategori'] != 'Umum' ? '<span class="badge badge-danger"><i class="fa fa-info-circle"></i> ' . $li['jns_kategori'] . '</span>' : '';
			$row[] = $jns_dokumen;

			$detail = '<b>' . $li['perihal'] . '</b><br>';
			$detail .= '<span>Pembuat: ' . $li['nm_pegawai'] . '<hr>No. ' . $li['jns_dokumen'] . ': ' . $li['no_dokumen'] . '</span>';
			$row[] = $detail;

			$exp = '';
			foreach (unserialize($li['unit_tujuan']) as $val) {
				$exp .= $val . '<br>';
			}
			$row[] = $exp;

			$date = explode(' ', $li['createDate']);
			$row[] = tgl_indo($date[0]);
			$row[] = $li['sts_dokumen'];

			$aksi = '<center>';
			// priview file before download
			$download = $li['file_dokumen'] != null ? '<a href="' . base_url('assets/' . $li['path_folder'] . '/' . $li['file_dokumen']) . '" target="_blank" class="badge badge-warning" style="cursor: pointer"><i class="fa fa-download"></i></a>&nbsp;' : '';
			$aksi .= $download;

			$aksi .= '<span class="badge badge-info" style="cursor: pointer" onclick="view(\'' . $li['id_dokumen'] . '\')"><i class="fa fa-eye"></i></span>&nbsp;';
			$aksi .= '<span class="badge badge-success" style="cursor: pointer" onclick="sunting(\'' . $li['id_dokumen'] . '\')"><i class="fa fa-edit"></i></span>&nbsp;';
			$aksi .= '<span class="badge badge-danger" style="cursor: pointer" onclick="hapus(\'' . $li['id_dokumen'] . '\')"><i class="fa fa-trash"></i></span>';
			$aksi .= '</center>';
			$row[] = $aksi;

			$data[] = $row;
		}

		$output = array(
			'draw' => intval($_POST['draw']),
			'recordsTotal' => $this->m_dok_keluar->get_all_data(),
			'recordsFiltered' => $this->m_dok_keluar->count_filtered(),
			'data' => $data
		);
		echo json_encode($output);
		exit();
	}

	function get_data($id)
	{
		$key['id_dokumen'] = $id;
		$data = $this->m_dok_keluar->read($key)->row_array();

		$unit = unserialize($data['unit_tujuan']);
		// $list = array_walk($unit, function(&$val, $key){
		// 	$val = str_replace(' & ', ' and ', $val);
		// });
		$list = array_map(function ($val) {
			return html_entity_decode($val, ENT_QUOTES, 'UTF-8');
		}, $unit);

		$respon = array(
			'id_dokumen' => $data['id_dokumen'],
			'no_dokumen' => $data['no_dokumen'],
			'jns_dokumen' => $data['jns_dokumen'],
			'dari' => $data['dari'],
			'unit_tujuan' => $list,
			'perihal' => strtoupper(reverse($data['perihal'])),
			'pembuat' => $data['pembuat'],
			'lampiran' => $data['lampiran'],
			'kategori' => $data['kategori'],
			'sts_dokumen' => $data['sts_dokumen'],
			'catatan' => $data['catatan'],
			'file_dokumen' => $data['file_dokumen'],
			'createDate' => $data['createDate']
		);
		echo json_encode($respon);
		exit;
	}

	public function insert()
	{
		$this->validasi();

		// buat folder sesuai tahun dan bulan
		$nm_folder = date('Y-m');
		if (!is_dir('assets/berkas-keluar/' . $nm_folder)) {
			mkdir('./assets/berkas-keluar/' . $nm_folder, 0777, true);
		}

		$config = array(
			'upload_path' => './assets/berkas-keluar/' . $nm_folder,
			'allowed_types' => 'pdf'
		);

		$this->load->library('upload', $config);

		$dokumen = $this->m_jns_dokumen->read(['id_jns_dokumen' => input('jns_dokumen')])->row_array();
		$config = $this->m_config->read(['status' => 1])->row_array();

		$no = (int) $dokumen['counter_dokumen'] + 1;
		if ($no > 999) $cond = $no;
		elseif ($no > 99) $cond = '0' . $no;
		elseif ($no > 9) $cond = '00' . $no;
		else $cond = '000' . $no;

		// set tahun terbitan
		$no_dok = substr($config['thn_dokumen'], 2, 1) - 2 . substr($config['thn_dokumen'], -1);
		// set counter nomor dokumen & kode dokumen
		$no_dok .= '/' . $cond . '-' . $dokumen['id_jns_dokumen'];
		// set kode group
		$no_dok .= '/' . $config['nm_group'];

		$data = array(
			'no_dokumen' => $no_dok,
			'jns_dokumen' => input('jns_dokumen'),
			'dari' => $config['nm_group'],
			// 'unit_tujuan' => serialize($_POST['li_tujuan']),
			'perihal' => strtoupper(input('perihal')),
			'pembuat' => input('pembuat'),
			'lampiran' => input('lampiran') == '' ? 0 : input('lampiran'),
			'kategori' => input('kategori'),
			'sts_dokumen' => input('sts_dokumen'),
			'catatan' => input('catatan') == '' ? NULL : input('catatan')
		);

		$tujuan[] = input('tujuan_lain');
		if (isset($_POST['li_tujuan'])) {
			$data['unit_tujuan'] = serialize($_POST['li_tujuan']);
		} else {
			$data['unit_tujuan'] = serialize($tujuan);
		}

		if ($this->upload->do_upload('file')) {
			$fileData = $this->upload->data();
			$data['path_folder'] = 'berkas-keluar/' . $nm_folder;
			$data['file_dokumen'] = $fileData['file_name'];
		}

		$this->db->trans_begin();
		$this->m_jns_dokumen->update(['counter_dokumen' => $no], ['id_jns_dokumen' => input('jns_dokumen')]);
		$this->m_dok_keluar->create($data);

		if ($this->db->trans_status() === TRUE) {
			$this->db->trans_commit();

			$title = 'Sukses';
			$text = $dokumen['jns_dokumen'] . ' telah berhasil dibuat dengan nomor ' . $no_dok;
			$icon = 'success';
		} else {
			$this->db->trans_rollback();

			$title = 'Oops!';
			$text = 'Terjadi kesalahan pada sistem, harap coba kembali';
			$icon = 'warning';
		}

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function update()
	{
		$this->validasi();

		// buat folder sesuai tahun dan bulan
		$nm_folder = date('Y-m');
		if (!is_dir('assets/berkas-keluar/' . $nm_folder)) {
			mkdir('./assets/berkas-keluar/' . $nm_folder, 0777, true);
		}

		$config = array(
			'upload_path' => './assets/berkas-keluar/' . $nm_folder,
			'allowed_types' => 'pdf'
		);

		$this->load->library('upload', $config);

		$key['id_dokumen'] = input('id_dok');

		$data = array(
			'jns_dokumen' => input('jns_dokumen'),
			// 'unit_tujuan' => serialize($_POST['li_tujuan']),
			'perihal' => strtoupper(input('perihal')),
			'pembuat' => input('pembuat'),
			'lampiran' => input('lampiran') == '' ? 0 : input('lampiran'),
			'kategori' => input('kategori'),
			'sts_dokumen' => input('sts_dokumen'),
			'catatan' => input('catatan') == '' ? NULL : input('catatan')
		);

		$tujuan[] = input('tujuan_lain');
		if (isset($_POST['li_tujuan'])) {
			$data['unit_tujuan'] = serialize($_POST['li_tujuan']);
		} else {
			$data['unit_tujuan'] = serialize($tujuan);
		}

		if ($this->upload->do_upload('file')) {
			$fileData = $this->upload->data();
			$data['file_dokumen'] = $fileData['file_name'];

			// perikasa apakah path_folder pada database sudah ada atau belum
			$path = $this->m_dok_keluar->read($key)->row_array();
			if ($path['path_folder'] == null) {
				// tambahkan path_folder jika belum ada
				$data['path_folder'] = 'berkas-keluar/' . $nm_folder;
			} else {
				unlink('./assets/' . $path['path_folder'] . '/' . $path['file_dokumen']);
			}
		}

		$this->m_dok_keluar->update($data, $key);

		$title = 'Sukses';
		$text = 'Dokumen telah berhasil diubah';
		$icon = 'success';

		echo json_encode(['status' => true, 'title' => $title, 'icon' => $icon, 'text' => $text]);
		exit;
	}

	public function delete($id)
	{
		$key['id_dokumen'] = $id;

		$file = $this->m_dok_keluar->read($key)->row_array();
		if ($file['file_dokumen'] != null) {
			unlink('./assets/' . $file['path_folder'] . '/' . $file['file_dokumen']);
		}
		$this->m_dok_keluar->delete($key);

		echo json_encode(['status' => true]);
		exit;
	}
}
