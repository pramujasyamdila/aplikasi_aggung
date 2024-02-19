<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create_product($data)
    {
        $this->db->insert('tbl_product', $data);
    }

    public function get_products()
    {
        return $this->db->get('tbl_product')->result();
    }

    public function get_product($id)
    {
        return $this->db->get_where('tbl_product', array('id_product' => $id))->row();
    }

    public function update_product($id, $data)
    {
        $this->db->where('id_product', $id);
        $this->db->update('tbl_product', $data);
    }

    public function delete($id)
    {
        $this->db->delete('tbl_product', array('id_product' => $id));
    }
}
