<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard_model extends CI_Model
{

    

    public function Pelanggan_voucher()
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('id_role', '3');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

    public function Pelanggan_konter()
	{
		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where('id_role', '2');
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}

    public function Get_tbl_User()
	{
		$query = $this->db->get('tbl_user');
		if ($query->num_rows() > 0) {
			return $query->num_rows();
		} else {
			return 0;
		}
	}


  



}
