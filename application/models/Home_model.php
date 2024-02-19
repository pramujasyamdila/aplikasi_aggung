<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_home($data)
    {
        $this->db->insert('tbl_home', $data);
    }

    public function get_homes()
    {
        return $this->db->get('tbl_home')->result();
    }

    public function get_home($id)
    {
        return $this->db->get_where('tbl_home', array('id_home' => $id))->row();
    }

    public function update_home($id, $data)
    {
        $this->db->where('id_home', $id);
        $this->db->update('tbl_home', $data);
    }

    public function delete_home($id)
    {
        $this->db->delete('tbl_home', array('id_home' => $id));
    }

    // home text

    public function get_text_homes()
    {
        return $this->db->get('tbl_home_text')->result();
    }

    public function get_text_home($id)
    {
        return $this->db->get_where('tbl_home_text', array('id_home_text' => $id))->row();
    }

    public function update_text_home($id, $data)
    {
        $this->db->where('id_home_text', $id);
        $this->db->update('tbl_home_text', $data);
    }
}
