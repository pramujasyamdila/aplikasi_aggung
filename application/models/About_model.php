<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class About_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_about($data)
    {
        $this->db->insert('tbl_about', $data);
    }

    public function get_abouts()
    {
        return $this->db->get('tbl_about')->result();
    }

    public function get_about($id)
    {
        return $this->db->get_where('tbl_about', array('id_about' => $id))->row();
    }

    public function update_about($id, $data)
    {
        $this->db->where('id_about', $id);
        $this->db->update('tbl_about', $data);
    }

    public function delete_about($id)
    {
        $this->db->delete('tbl_about', array('id_about' => $id));
    }

    // about text deskripsi


    public function get_abouts_text()
    {
        return $this->db->get('tbl_about_text')->result();
    }

    public function get_about_text($id)
    {
        return $this->db->get_where('tbl_about_text', array('id_about_text' => $id))->row();
    }

    public function update_about_text($id, $data)
    {
        $this->db->where('id_about_text', $id);
        $this->db->update('tbl_about_text', $data);
    }
}
