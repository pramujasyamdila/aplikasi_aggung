<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Service_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_service($data)
    {
        $this->db->insert('tbl_service', $data);
    }

    public function get_services()
    {
        return $this->db->get('tbl_service')->result();
    }

    public function get_service($id)
    {
        return $this->db->get_where('tbl_service', array('id_service' => $id))->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id_service', $id);
        $this->db->update('tbl_service', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tbl_service', array('id_service' => $id));
    }
}
