<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contact_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_contact($data)
    {
        $this->db->insert('tbl_contact', $data);
    }

    public function get_contacts()
    {
        return $this->db->get('tbl_contact')->result();
    }

    public function get_contact($id)
    {
        return $this->db->get_where('tbl_contact', array('id_contact' => $id))->row();
    }

    public function update_contact($id, $data)
    {
        $this->db->where('id_contact', $id);
        $this->db->update('tbl_contact', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tbl_contact', array('id_contact' => $id));
    }
}
