<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_model extends CI_Model
{

	var $table = 'tbl_pegawai';
	var $order = array('id_pegawai', 'nama_pegawai', 'nip', 'username', 'nama_role', 'id_pegawai');
	var $column_search = array('id_pegawai', 'nama_pegawai', 'nip', 'username', 'nama_role', 'id_pegawai');

	private function _get_data_query()
	{
		$i = 0;
		$this->db->select('*');
		$this->db->from('tbl_pegawai');
		$this->db->join('tbl_role', 'tbl_pegawai.id_role = tbl_role.id_role', 'left');
		$this->db->where('tbl_pegawai.id_role != ', 1);
		$this->db->where('tbl_pegawai.id_role != ', 2);
		$this->db->where('tbl_pegawai.id_role != ', 6);

		foreach ($this->column_search as $item) // looping awal
		{
			if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if ($i === 0) // looping awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like(
						$item,
						$_POST['search']['value']
					);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else {
			$this->db->order_by('id_pegawai', 'DESC');
		}
	}

	public function getdatatable()
	{
		$this->_get_data_query();
		if ($_POST['length'] != -1) {
			$this->db->limit($_POST['length'], $_POST['start']);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered_data()
	{
		$this->_get_data_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_data()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function getAll()
	{
		$this->db->select('*');
		$this->db->from('tbl_pegawai');
		$data = $this->db->get();
		return $data->result_array();
	}

	// ambil_unit_kerja
	public function ambil_unit_kerja()
	{
		$this->db->select('*');
		$this->db->from('tbl_unit_kerja');
		$data = $this->db->get();
		return $data->result_array();
	}

	public function getRole()
	{
		$this->db->select('*');
		$this->db->from('tbl_role');
		$this->db->where_not_in('id_role', 1);
		$this->db->where_not_in('id_role', 2);
		$this->db->where_not_in('id_role', 6);
		$data = $this->db->get();
		return $data->result_array();
	}

	//untuk menambah panitia di bagian panitia pemilihan
	public function getByPanitia()
	{
		$this->db->select('*');
		$this->db->from('tbl_pegawai');
		$this->db->where('id_role', 3);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getDetail()
	{
		$this->db->select('*');
		$this->db->from('tbl_pegawai');
		$data = $this->db->get();
		return $data->row_array();
	}

	public function getById($id_pegawai)
	{

		$this->db->select('*');
		$this->db->from('tbl_pegawai');
		$this->db->join('tbl_role', 'tbl_pegawai.id_role = tbl_role.id_role', 'left');
		$this->db->join('tbl_unit_kerja', 'tbl_pegawai.jabatan = tbl_unit_kerja.id_unit_kerja', 'left');
		$this->db->where('id_pegawai', $id_pegawai);
		// $query = $this->db->query("SELECT * FROM tbl_pegawai LEFT JOIN tbl_role USING(id_role) WHERE id_pegawai ='$id_pegawai'");
		// return $query->row_array();
		$data = $this->db->get();
		return $data->row_array();
	}

	public function insert($data)
	{
		$this->db->insert('tbl_pegawai', $data);
	}

	public function update($data, $id_pegawai)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('tbl_pegawai', $data);
	}

	public function delete($id_pegawai)
	{
		$this->db->delete('tbl_pegawai', ['id_pegawai' => $id_pegawai]);
	}

	public function updatepassword($data, $id_pegawai)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('tbl_pegawai', $data);
	}
}
