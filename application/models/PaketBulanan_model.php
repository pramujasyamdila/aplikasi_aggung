<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PaketBulanan_model extends CI_Model
{

    public function get_all()
    {
        return $this->db->get('tbl_paket_bulanan_pilihan')->result();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('tbl_paket_bulanan_pilihan', array('id_paket_bulanan_pilihan' => $id))->row();
    }

    public function insert($data)
    {
        $this->db->insert('tbl_paket_bulanan_pilihan', $data);
    }

    public function update($id, $data)
    {
        $this->db->where('id_paket_bulanan_pilihan', $id);
        $this->db->update('tbl_paket_bulanan_pilihan', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_paket_bulanan_pilihan', $id);
        $this->db->delete('tbl_paket_bulanan_pilihan');
    }
}
