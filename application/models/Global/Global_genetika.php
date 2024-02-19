<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Global_genetika extends CI_Model
{

    // ini crud user
    var $table_user = 'tbl_user';
    var $order_user = array('id_user', 'nama_user', 'username', 'id_user');
    var $column_search_user = array('id_user', 'nama_user', 'username', 'id_user');

    private function _get_data_query()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_user');
        foreach ($this->column_search_user as $item) // looping awal
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

                if (count($this->column_search_user) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_user[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_user', 'DESC');
        }
    }

    public function get_table_user()
    {
        $this->_get_data_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_user()
    {
        $this->_get_data_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_user()
    {
        $this->db->from($this->table_user);
        return $this->db->count_all_results();
    }
    public function add_user($data)
    {
        $this->db->insert('tbl_user', $data);
        return $this->db->affected_rows();
    }

    public function by_id_user($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('tbl_user.id_user', $id_user);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_user($id_user)
    {
        $this->db->delete('tbl_user', ['id_user' => $id_user]);
    }


    public function update_user($data, $where)
    {
        $this->db->update('tbl_user', $data, $where);
    }

    // ini crud jabatan

    // ini crud jabatan
    var $table_jabatan = 'tbl_jabatan';
    var $order_jabatan = array('id_jabatan', 'nama_jabatan', 'id_jabatan');
    var $column_search_jabatan = array('id_jabatan', 'nama_jabatan', 'id_jabatan');

    private function _get_data_query_jabatan()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_jabatan');
        foreach ($this->column_search_jabatan as $item) // looping awal
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

                if (count($this->column_search_jabatan) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_jabatan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_jabatan', 'DESC');
        }
    }

    public function get_table_jabatan()
    {
        $this->_get_data_query_jabatan();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_jabatan()
    {
        $this->_get_data_query_jabatan();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_jabatan()
    {
        $this->db->from($this->table_jabatan);
        return $this->db->count_all_results();
    }
    public function add_jabatan($data)
    {
        $this->db->insert('tbl_jabatan', $data);
        return $this->db->affected_rows();
    }

    public function by_id_jabatan($id_jabatan)
    {
        $this->db->select('*');
        $this->db->from('tbl_jabatan');
        $this->db->where('tbl_jabatan.id_jabatan', $id_jabatan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_jabatan($id_jabatan)
    {
        $this->db->delete('tbl_jabatan', ['id_jabatan' => $id_jabatan]);
    }


    public function update_jabatan($data, $where)
    {
        $this->db->update('tbl_jabatan', $data, $where);
    }

    // ini crud divisi

    // ini crud divisi
    var $table_divisi = 'tbl_divisi';
    var $order_divisi = array('id_divisi', 'nama_divisi', 'id_divisi');
    var $column_search_divisi = array('id_divisi', 'nama_divisi', 'id_divisi');

    private function _get_data_query_divisi()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_divisi');
        foreach ($this->column_search_divisi as $item) // looping awal
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

                if (count($this->column_search_divisi) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_divisi[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_divisi', 'DESC');
        }
    }

    public function get_table_divisi()
    {
        $this->_get_data_query_divisi();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_divisi()
    {
        $this->_get_data_query_divisi();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_divisi()
    {
        $this->db->from($this->table_divisi);
        return $this->db->count_all_results();
    }
    public function add_divisi($data)
    {
        $this->db->insert('tbl_divisi', $data);
        return $this->db->affected_rows();
    }

    public function by_id_divisi($id_divisi)
    {
        $this->db->select('*');
        $this->db->from('tbl_divisi');
        $this->db->where('tbl_divisi.id_divisi', $id_divisi);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_divisi($id_divisi)
    {
        $this->db->delete('tbl_divisi', ['id_divisi' => $id_divisi]);
    }


    public function update_divisi($data, $where)
    {
        $this->db->update('tbl_divisi', $data, $where);
    }


    // ini crud ruangan
    var $table_ruangan = 'tbl_ruangan';
    var $order_ruangan = array('id_ruangan', 'nama_ruangan', 'id_ruangan');
    var $column_search_ruangan = array('id_ruangan', 'nama_ruangan', 'id_ruangan');

    private function _get_data_query_ruangan()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_ruangan');
        foreach ($this->column_search_ruangan as $item) // looping awal
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

                if (count($this->column_search_ruangan) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_ruangan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_ruangan', 'DESC');
        }
    }

    public function get_table_ruangan()
    {
        $this->_get_data_query_ruangan();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_ruangan()
    {
        $this->_get_data_query_ruangan();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_ruangan()
    {
        $this->db->from($this->table_ruangan);
        return $this->db->count_all_results();
    }
    public function add_ruangan($data)
    {
        $this->db->insert('tbl_ruangan', $data);
        return $this->db->affected_rows();
    }

    public function by_id_ruangan($id_ruangan)
    {
        $this->db->select('*');
        $this->db->from('tbl_ruangan');
        $this->db->where('tbl_ruangan.id_ruangan', $id_ruangan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_ruangan($id_ruangan)
    {
        $this->db->delete('tbl_ruangan', ['id_ruangan' => $id_ruangan]);
    }


    public function update_ruangan($data, $where)
    {
        $this->db->update('tbl_ruangan', $data, $where);
    }


    // ini crud waktu

    // ini crud waktu
    var $table_waktu = 'tbl_waktu';
    var $order_waktu = array('id_waktu', 'nama_waktu', 'id_waktu');
    var $column_search_waktu = array('id_waktu', 'nama_waktu', 'id_waktu');

    private function _get_data_query_waktu()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_waktu');
        foreach ($this->column_search_waktu as $item) // looping awal
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

                if (count($this->column_search_waktu) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_waktu[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_waktu', 'DESC');
        }
    }

    public function get_table_waktu()
    {
        $this->_get_data_query_waktu();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_waktu()
    {
        $this->_get_data_query_waktu();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_waktu()
    {
        $this->db->from($this->table_waktu);
        return $this->db->count_all_results();
    }
    public function add_waktu($data)
    {
        $this->db->insert('tbl_waktu', $data);
        return $this->db->affected_rows();
    }

    public function by_id_waktu($id_waktu)
    {
        $this->db->select('*');
        $this->db->from('tbl_waktu');
        $this->db->where('tbl_waktu.id_waktu', $id_waktu);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_waktu($id_waktu)
    {
        $this->db->delete('tbl_waktu', ['id_waktu' => $id_waktu]);
    }


    public function update_waktu($data, $where)
    {
        $this->db->update('tbl_waktu', $data, $where);
    }


    // ini crud hari

    // ini crud hari
    var $table_hari = 'tbl_hari';
    var $order_hari = array('id_hari', 'nama_hari', 'id_hari');
    var $column_search_hari = array('id_hari', 'nama_hari', 'id_hari');

    private function _get_data_query_hari()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_hari');
        foreach ($this->column_search_hari as $item) // looping awal
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

                if (count($this->column_search_hari) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_hari[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_hari', 'DESC');
        }
    }

    public function get_table_hari()
    {
        $this->_get_data_query_hari();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_hari()
    {
        $this->_get_data_query_hari();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_hari()
    {
        $this->db->from($this->table_hari);
        return $this->db->count_all_results();
    }
    public function add_hari($data)
    {
        $this->db->insert('tbl_hari', $data);
        return $this->db->affected_rows();
    }

    public function by_id_hari($id_hari)
    {
        $this->db->select('*');
        $this->db->from('tbl_hari');
        $this->db->where('tbl_hari.id_hari', $id_hari);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_hari($id_hari)
    {
        $this->db->delete('tbl_hari', ['id_hari' => $id_hari]);
    }


    public function update_hari($data, $where)
    {
        $this->db->update('tbl_hari', $data, $where);
    }



    // ini crud meeting

    // ini crud meeting
    var $table_meeting = 'tbl_meeting';
    var $order_meeting = array('id_meeting', 'nama_meeting', 'id_meeting');
    var $column_search_meeting = array('id_meeting', 'nama_meeting', 'id_meeting');

    private function _get_data_query_meeting()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_meeting');
        // jabatan
        $this->db->join('tbl_jabatan', 'tbl_meeting.id_jabatan = tbl_jabatan.id_jabatan', 'left');
        // divisi
        $this->db->join('tbl_divisi', 'tbl_meeting.id_divisi = tbl_divisi.id_divisi', 'left');
        // waktu
        $this->db->join('tbl_waktu', 'tbl_meeting.id_waktu = tbl_waktu.id_waktu', 'left');
        // hari
        $this->db->join('tbl_hari', 'tbl_meeting.id_hari = tbl_hari.id_hari', 'left');
        foreach ($this->column_search_meeting as $item) // looping awal
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

                if (count($this->column_search_meeting) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order_meeting[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('id_meeting', 'DESC');
        }
    }

    public function get_table_meeting()
    {
        $this->_get_data_query_meeting();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_meeting()
    {
        $this->_get_data_query_meeting();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_meeting()
    {
        $this->db->select('*');
        $this->db->from('tbl_meeting');
        // jabatan
        $this->db->join('tbl_jabatan', 'tbl_meeting.id_jabatan = tbl_jabatan.id_jabatan', 'left');
        // divisi
        $this->db->join('tbl_divisi', 'tbl_meeting.id_divisi = tbl_divisi.id_divisi', 'left');
        // waktu
        $this->db->join('tbl_waktu', 'tbl_meeting.id_waktu = tbl_waktu.id_waktu', 'left');
        // hari
        $this->db->join('tbl_hari', 'tbl_meeting.id_hari = tbl_hari.id_hari', 'left');
        return $this->db->count_all_results();
    }
    public function add_meeting($data)
    {
        $this->db->insert('tbl_meeting', $data);
        return $this->db->affected_rows();
    }

    public function by_id_meeting($id_meeting)
    {
        $this->db->select('*');
        $this->db->from('tbl_meeting');
        // jabatan
        $this->db->join('tbl_jabatan', 'tbl_meeting.id_jabatan = tbl_jabatan.id_jabatan', 'left');
        // divisi
        $this->db->join('tbl_divisi', 'tbl_meeting.id_divisi = tbl_divisi.id_divisi', 'left');
        // waktu
        $this->db->join('tbl_waktu', 'tbl_meeting.id_waktu = tbl_waktu.id_waktu', 'left');
        // hari
        $this->db->join('tbl_hari', 'tbl_meeting.id_hari = tbl_hari.id_hari', 'left');
        $this->db->where('tbl_meeting.id_meeting', $id_meeting);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_meeting($id_meeting)
    {
        $this->db->delete('tbl_meeting', ['id_meeting' => $id_meeting]);
    }


    public function update_meeting($data, $where)
    {
        $this->db->update('tbl_meeting', $data, $where);
    }

    // INI UNTUK RESULUTNYA
    // jabatan
    public function by_id_result_jabatan()
    {
        $this->db->select('*');
        $this->db->from('tbl_jabatan');
        $query = $this->db->get();
        return $query->result_array();
    }
    // divisi
    public function by_id_result_divisi()
    {
        $this->db->select('*');
        $this->db->from('tbl_divisi');
        $query = $this->db->get();
        return $query->result_array();
    }
    // waktu
    public function by_id_result_waktu()
    {
        $this->db->select('*');
        $this->db->from('tbl_waktu');
        $query = $this->db->get();
        return $query->result_array();
    }
    // hari
    public function by_id_result_hari()
    {
        $this->db->select('*');
        $this->db->from('tbl_hari');
        $query = $this->db->get();
        return $query->result_array();
    }

    // meeting
    public function ambil_data_meeting()
    {
        $this->db->select('*');
        $this->db->from('tbl_meeting');
        // jabatan
        $this->db->join('tbl_jabatan', 'tbl_meeting.id_jabatan = tbl_jabatan.id_jabatan', 'left');
        // divisi
        $this->db->join('tbl_divisi', 'tbl_meeting.id_divisi = tbl_divisi.id_divisi', 'left');
        // waktu
        $this->db->join('tbl_waktu', 'tbl_meeting.id_waktu = tbl_waktu.id_waktu', 'left');
        // hari
        $this->db->join('tbl_hari', 'tbl_meeting.id_hari = tbl_hari.id_hari', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }
    // ruangan
    public function ambil_ruangan()
    {
        $this->db->select('*');
        $this->db->from('tbl_ruangan');
        $query = $this->db->get();
        return $query->result_array();
    }
}
