<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_unit_tujuan extends CI_Model
{

	/*
	|--------------------------------------------------------------------------
	| Datatables Server-side Processing
	|--------------------------------------------------------------------------
	*/

	var $table = 'tbl_unit';
	var $column_order = array(null, 'kd_unit', 'nm_unit', null);
	var $column_search = array('kd_unit', 'nm_unit');
	var $order = array('createDate' => 'desc');

	function _get_datatable_query()
	{
		$this->db->from($this->table);

		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) $this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatable_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	function count_filtered()
	{
		$this->_get_datatable_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function get_all_data()
	{
		$this->db->get($this->table);
		return $this->db->count_all_results();
	}

	/*
	|--------------------------------------------------------------------------
	| Module CRUD
	|--------------------------------------------------------------------------
	*/

	public function show()
	{
		$data = $this->db->get($this->table)->result_array();
		return $data;
	}

	public function create($data)
	{
		$this->db->insert($this->table, $data);
	}

	public function read($key)
	{
		$data = $this->db->get_where($this->table, $key);
		return $data;
	}

	public function update($data, $key)
	{
		$this->db->update($this->table, $data, $key);
	}

	public function delete($key)
	{
		$this->db->delete($this->table, $key);
	}
}
