<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_login extends CI_Model
{
	private $_table = 'tbl_user';

	public function login($username, $password)
	{
		$where = array(
			'username' => $username,
			'password' => $password
		);
		$cek = $this->db->get_where($this->_table, $where);
		return $cek->num_rows();
	}

	public function get_user($username)
	{
		$user = $this->db->get_where($this->_table, ['username' => $username])->row_array();
		return $user;
	}
}
