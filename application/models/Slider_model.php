<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Slider_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_slider_price($data)
    {
        $this->db->insert('tbl_slider_price', $data);
    }

    public function get_sliders()
    {
        return $this->db->get('tbl_slider_price')->result();
    }

    public function get_slider($id)
    {
        return $this->db->get_where('tbl_slider_price', array('id_slider_price' => $id))->row();
    }

    public function update_slider($id, $data)
    {
        $this->db->where('id_slider_price', $id);
        $this->db->update('tbl_slider_price', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tbl_slider_price', array('id_slider_price' => $id));
    }
}
