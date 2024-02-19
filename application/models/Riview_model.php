<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Riview_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_riview($data)
    {
        $this->db->insert('tbl_riview', $data);
    }

    public function get_riviews()
    {
        return $this->db->get('tbl_riview')->result();
    }

    public function get_riview($id)
    {
        return $this->db->get_where('tbl_riview', array('id_riview' => $id))->row();
    }

    public function update_riview($id, $data)
    {
        $this->db->where('id_riview', $id);
        $this->db->update('tbl_riview', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tbl_riview', array('id_riview' => $id));
    }
}
