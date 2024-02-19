<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Global_spk extends CI_Model
{

    // ini crud lamaran
    var $table_lamaran = 'tbl_lamaran';
    var $order_lamaran = array('id_lamaran', 'nama_lengkap', 'id_lamaran', 'id_lamaran');
    var $column_search_lamaran = array('id_lamaran', 'nama_lengkap', 'id_lamaran', 'id_lamaran');

    private function _get_data_query()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_lamaran');
        foreach ($this->column_search_lamaran as $item) // looping awal
        {
            if ($_POST['search']['value']) {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like(
                        $item,
                        $_POST['search']['value']
                    );
                }

                if (count($this->column_search_lamaran) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_lamaran[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_lamaran', 'DESC');
        }
    }

    public function get_table_lamaran()
    {
        $this->_get_data_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_lamaran()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_lamaran()
    {
        $this->db->from($this->table_lamaran);
        return $this->db->count_all_results();
    }
    public function add_lamaran($data)
    {
        $this->db->insert('tbl_lamaran', $data);
        return $this->db->affected_rows();
    }

    public function by_id_lamaran($id_lamaran)
    {
        $this->db->select('*');
        $this->db->from('tbl_lamaran');
        $this->db->where('tbl_lamaran.id_lamaran', $id_lamaran);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_lamaran($id_lamaran)
    {
        $this->db->delete('tbl_lamaran', ['id_lamaran' => $id_lamaran]);
    }


    public function update_lamaran($data, $where)
    {
        $this->db->update('tbl_lamaran', $data, $where);
    }

    // ini crud lamaran
    private function _get_data_query_kandidat()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_lamaran');
        $this->db->where('tbl_lamaran.education !=', NULL);
        foreach ($this->column_search_lamaran as $item) // looping awal
        {
            if ($_POST['search']['value']) {

                if ($i === 0) // looping awal
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like(
                        $item,
                        $_POST['search']['value']
                    );
                }

                if (count($this->column_search_lamaran) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_lamaran[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_lamaran', 'DESC');
        }
    }

    public function get_table_kandidat()
    {
        $this->_get_data_query_kandidat();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_kandidat()
    {
        $this->_get_data_query_kandidat();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_kandidat()
    {
        $this->db->from($this->table_lamaran);
        return $this->db->count_all_results();
    }
}
