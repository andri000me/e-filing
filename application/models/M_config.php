<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_config extends CI_Model
{
	private $_table = 'tbl_config';

	public function show()
	{
		$data = $this->db->get($this->_table)->result_array();
		return $data;
	}
	
	public function create($data)
	{
		$this->db->insert($this->_table, $data);
	}

	public function read($key)
	{
		$data = $this->db->get_where($this->_table, $key);
		return $data;
	}

	public function update($data, $key)
	{
		$this->db->update($this->_table, $data, $key);
	}

	public function delete($key)
	{
		$this->db->delete($this->_table, $key);
	}
}
