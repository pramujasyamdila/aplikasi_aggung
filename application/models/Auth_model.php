<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

	public function login($username)
	{

		$this->db->select('*');
		$this->db->from('tbl_user');
		$this->db->where(array(
			'tbl_user.username' => $username
		));
		$this->db->group_by('tbl_user.id_user');
		return $this->db->get()->row();
	}

	public function update($where, $data)
	{
		$this->db->update('tbl_user', $data, $where);
		return $this->db->affected_rows();
	}
}
