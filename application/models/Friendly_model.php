<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Friendly_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    

    public function get_friendlys()
    {
        return $this->db->get('tbl_friendly')->result();
    }

    public function get_friendly($id)
    {
        return $this->db->get_where('tbl_friendly', array('id_friendly' => $id))->row();
    }

    public function update($id, $data)
    {
        $this->db->where('id_friendly', $id);
        $this->db->update('tbl_friendly', $data);
    }

    //image

    public function create_friendly_image($data)
    {
        $this->db->insert('tbl_friendly_image', $data);
    }

    public function get_friendly_images()
    {
        return $this->db->get('tbl_friendly_image')->result();
    }

    public function get_friendly_image($id)
    {
        return $this->db->get_where('tbl_friendly_image', array('id_friendly_image' => $id))->row();
    }

    public function update_friendly_image($id, $data)
    {
        $this->db->where('id_friendly_image', $id);
        $this->db->update('tbl_friendly_image', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tbl_friendly_image', array('id_friendly_image' => $id));
    }

}
