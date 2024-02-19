<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Global_zahir_model extends CI_Model
{
    public function login($username)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->where('username', $username);
        return $this->db->get()->row();
    }

    var $table = 'tbl_zahir_user';
    var $order = array('id_user', 'nama_user', 'username', 'id_user');
    var $column_search = array('id_user', 'nama_user', 'username', 'id_user');

    private function _get_data_query()
    {
        $i = 0;
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        foreach ($this->column_search as $item) // looping awal
        {
            if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {

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

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
    public function add_user($data)
    {
        $this->db->insert('tbl_zahir_user', $data);
        return $this->db->affected_rows();
    }




    public function by_id_user($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->where('tbl_zahir_user.id_user', $id_user);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_user($id_user)
    {
        $this->db->delete('tbl_zahir_user', ['id_user' => $id_user]);
    }


    public function update_user($data, $where)
    {
        $this->db->update('tbl_zahir_user', $data, $where);
    }



    // INI UNTUK IKLAN
    private function _get_data_query_iklan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_iklan');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_iklan.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->order_by('tbl_zahir_iklan.id_iklan', 'DESC');
    }

    public function get_table_iklan()
    {
        $this->_get_data_query_iklan();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_iklan()
    {
        $this->_get_data_query_iklan();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_iklan()
    {
        $this->db->from('tbl_zahir_iklan');
        return $this->db->count_all_results();
    }
    public function add_iklan($data)
    {
        $this->db->insert('tbl_zahir_iklan', $data);
        return $this->db->affected_rows();
    }

    public function by_id_iklan($id_iklan)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_iklan');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_iklan.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_iklan.id_iklan', $id_iklan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_iklan($id_iklan)
    {
        $this->db->delete('tbl_zahir_iklan', ['id_iklan' => $id_iklan]);
    }


    public function update_iklan($data, $where)
    {
        $this->db->update('tbl_zahir_iklan', $data, $where);
    }

    public function result_iklan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_iklan');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_iklan.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_iklan.jenis_iklan', 'produk');
        $this->db->order_by('id_iklan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_iklan_langganan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_iklan');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_iklan.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_iklan.jenis_iklan', 'langganan');
        $this->db->order_by('id_iklan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    // INI UNTUK USER KONTER
    private function _get_data_query_user_konter()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->join('tbl_zahir_lokasi', 'tbl_zahir_user.id_lokasi = tbl_zahir_lokasi.id_lokasi', 'left');
        $this->db->order_by('tbl_zahir_user.id_user', 'DESC');
        $this->db->where('tbl_zahir_user.id_role', 2);
    }

    public function get_table_user_konter()
    {
        $this->_get_data_query_user_konter();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_user_konter()
    {
        $this->get_table_user_konter();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_user_konter()
    {
        $this->db->from('tbl_zahir_user');
        return $this->db->count_all_results();
    }

    // untuk umum
    private function _get_data_query_user_umum()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->order_by('tbl_zahir_user.id_user', 'DESC');
        $this->db->where('tbl_zahir_user.id_role', 3);
    }

    public function get_table_user_umum()
    {
        $this->_get_data_query_user_umum();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_user_umum()
    {
        $this->_get_data_query_user_umum();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_user_umum()
    {
        $this->db->from('tbl_zahir_user');
        return $this->db->count_all_results();
    }

    private function _get_data_query_user_bulanan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->order_by('tbl_zahir_user.id_user', 'DESC');
        $this->db->where('tbl_zahir_user.id_role', 4);
        $this->db->where('tbl_zahir_user.status_berlangganan', 1);
    }

    public function get_table_user_bulanan()
    {
        $this->_get_data_query_user_bulanan();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_user_bulanan()
    {
        $this->_get_data_query_user_bulanan();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_user_bulanan()
    {
        $this->db->from('tbl_zahir_user');
        return $this->db->count_all_results();
    }

    private function _get_data_query_user_bulanan_langganan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->order_by('tbl_zahir_user.id_user', 'DESC');
        $this->db->where('tbl_zahir_user.id_role', 4);
        $this->db->where('tbl_zahir_user.status_berlangganan', 2);
    }

    public function get_table_user_bulanan_langganan()
    {
        $this->_get_data_query_user_bulanan_langganan();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_user_bulanan_langganan()
    {
        $this->_get_data_query_user_bulanan_langganan();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_user_bulanan_langganan()
    {
        $this->db->from('tbl_zahir_user');
        return $this->db->count_all_results();
    }

    // INI UNTUK produk

    // INI UNTUK produk 
    private function _get_data_query_produk()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->order_by('tbl_zahir_produk.id_produk', 'DESC');
    }

    public function get_table_produk()
    {
        $this->_get_data_query_produk();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_produk()
    {
        $this->_get_data_query_produk();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_produk()
    {
        $this->db->from('tbl_zahir_produk');
        return $this->db->count_all_results();
    }

    // ini untuk_gamabr
    private function _get_data_query_produk_gambar($id_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_detail_gambar_produk');
        $this->db->where('id_produk', $id_produk);
        $this->db->order_by('tbl_zahir_detail_gambar_produk.id_produk', 'DESC');
    }

    public function get_table_produk_gambar($id_produk)
    {
        $this->_get_data_query_produk_gambar($id_produk);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_produk_gambar($id_produk)
    {
        $this->_get_data_query_produk_gambar($id_produk);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_produk_gambar($id_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_detail_gambar_produk');
        $this->db->where('id_produk', $id_produk);
        return $this->db->count_all_results();
    }


    private function _get_data_query_produk_mitra($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->where('tbl_zahir_produk.id_user', $id_user);
        $this->db->order_by('tbl_zahir_produk.id_produk', 'DESC');
    }

    public function get_table_produk_mitra($id_user)
    {
        $this->_get_data_query_produk_mitra($id_user);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_produk_mitra($id_user)
    {
        $this->_get_data_query_produk_mitra($id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_produk_mitra($id_user)
    {
        $this->db->from('tbl_zahir_produk');
        $this->db->where('tbl_zahir_produk.id_user', $id_user);
        return $this->db->count_all_results();
    }
    public function add_produk($data)
    {
        $this->db->insert('tbl_zahir_produk', $data);
        return $this->db->affected_rows();
    }

    public function add_produk_gambar($data)
    {
        $this->db->insert('tbl_zahir_detail_gambar_produk', $data);
        return $this->db->affected_rows();
    }

    public function by_id_produk($id_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->where('tbl_zahir_produk.id_produk', $id_produk);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function by_id_produk_gambar($id_detail_gambar_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_detail_gambar_produk');
        $this->db->where('tbl_zahir_detail_gambar_produk.id_detail_gambar_produk', $id_detail_gambar_produk);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function result_produk()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_produk_landing()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_produk_konter($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->order_by('id_produk', 'DESC');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function delete_produk($id_produk)
    {
        $this->db->delete('tbl_zahir_produk', ['id_produk' => $id_produk]);
    }


    public function delete_produk_gambar($id_detail_gambar_produk)
    {
        $this->db->delete('tbl_zahir_detail_gambar_produk', ['id_detail_gambar_produk' => $id_detail_gambar_produk]);
    }


    public function update_produk($data, $where)
    {
        $this->db->update('tbl_zahir_produk', $data, $where);
    }

    public function insert_produk($data)
    {
        $jumlah = count($data);
        if ($jumlah > 0) {
            $this->db->replace('tbl_zahir_produk', $data);
        }
    }

    public function row_produk($id_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function row_produk_gambar($id_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_detail_gambar_produk');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_detail_gambar_produk.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_detail_gambar_produk.id_produk', $id_produk);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function count_produk($id_produk)
    {
        $this->db->select('*');
        $this->db->from('trx_produk');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('sts_terjual', NULL);
        $query = $this->db->get();
        return $query->num_rows();
    }

    // ININUNTUK produk DETAIL
    private function _get_data_query_detail_produk($id_produk)
    {
        $this->db->select('*');
        $this->db->from('trx_produk');
        $this->db->where('trx_produk.id_produk', $id_produk);
        $this->db->order_by('trx_produk.id_produk', 'DESC');
    }

    public function get_table_detail_produk($id_produk)
    {
        $this->_get_data_query_detail_produk($id_produk);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_detail_produk($id_produk)
    {
        $this->_get_data_query_detail_produk($id_produk);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_detail_produk($id_produk)
    {
        $this->db->select('*');
        $this->db->from('trx_produk');
        $this->db->where('id_produk', $id_produk);
        return $this->db->count_all_results();
    }
    public function insert_detail_produk($data)
    {
        $jumlah = count($data);
        if ($jumlah > 0) {
            $this->db->replace('trx_produk', $data);
        }
    }
    public function add_detail_produk($data)
    {
        $this->db->insert('trx_produk', $data);
        return $this->db->affected_rows();
    }
    public function by_id_detail_produk($id_detail_produk)
    {
        $this->db->select('*');
        $this->db->from('trx_produk');
        $this->db->where('trx_produk.id_detail_produk', $id_detail_produk);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function delete_detail_produk($id_detail_produk)
    {
        $this->db->delete('trx_produk', ['id_detail_produk' => $id_detail_produk]);
    }
    public function cek_keranjnag($id_produk, $id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_keranjang');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_user', $id_user);;
        $query = $this->db->get();
        return $query->row_array();
    }
    public function cek_keranjnag_saya($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_keranjang');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_produk_keranjang.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_produk_keranjang.id_user', $id_user);;
        $query = $this->db->get();
        return $query->result_array();
    }

    public function by_row_produk_transaksi($no_order)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->where('tbl_zahir_produk_transaksi.no_order', $no_order);;
        $query = $this->db->get();
        return $query->row_array();
    }

    public function by_result_produk_transaksi($no_order)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_detail_transaksi');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_produk_detail_transaksi.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_produk_detail_transaksi.no_order', $no_order);;
        $query = $this->db->get();
        return $query->result_array();
    }

    // keranjang
    public function add_to_cart($data)
    {
        $this->db->insert('tbl_zahir_produk_keranjang', $data);
        return $this->db->affected_rows();
    }
    public function update_to_cart($where, $data)
    {
        $this->db->update('tbl_zahir_produk_keranjang', $data, $where);
        return $this->db->affected_rows();
    }

    public function update_ke_transaksi($data, $where)
    {
        $this->db->update('tbl_zahir_produk_transaksi', $data, $where);
        return $this->db->affected_rows();
    }




    public function delete_to_cart($id_cart)
    {
        $this->db->delete('tbl_zahir_produk_keranjang', ['id_cart' => $id_cart]);
        return $this->db->affected_rows();
    }
    public function cek_keranjnagbyid($id_cart)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_keranjang');
        $this->db->where('id_cart', $id_cart);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_kode_po($text = null, $table = null, $field = null)
    {
        $this->db->select_max('no_order');
        $this->db->like($field, $text, 'after');
        $this->db->order_by($field, 'desc');
        $this->db->limit(1);
        return $this->db->get($table)->row_array()[$field];
    }
    public function get_user($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->where('id_user', $id_user);
        $query = $this->db->get();
        return $query->row_array();
    }



    public function tambah_ke_tbl_zahir_produk_transaksi($data)
    {
        $this->db->insert('tbl_zahir_produk_transaksi', $data);
        return $this->db->affected_rows();
    }

    public function tambah_ke_tbl_zahir_produk_detail_transaksi($data)
    {
        $this->db->insert('tbl_zahir_produk_detail_transaksi', $data);
        return $this->db->affected_rows();
    }


    //  MODEL PEMBELI
    // INI UNTUK PEMEBELI
    public function result_orderan_pemebeli($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.id_user', $id_user);
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'PENDING');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_orderan_prosess_pembeli($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.id_user', $id_user);
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'PAID');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_orderan_selesai_pembeli($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.id_user', $id_user);
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'PAID');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function result_orderan_pembayarn_pembeli($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.id_user', $id_user);
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambah_ke_detail_rating_dan_komentar($data)
    {
        $this->db->insert('tbl_zahir_detail_rating', $data);
        return $this->db->affected_rows();
    }


    public function get_rating($id_produk)
    {
        $this->db->select_avg('nilai_rating');
        $this->db->from('tbl_zahir_detail_rating');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_komentar($id_produk)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_detail_rating');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_detail_rating.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_detail_rating.id_produk', $id_produk);
        $this->db->order_by('id_detail_rating_komentar');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_detail_transaksi($no_order)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_detail_transaksi');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_produk_detail_transaksi.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_produk_detail_transaksi.no_order', $no_order);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_row_transaksi($no_order)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('no_order', $no_order);
        $query = $this->db->get();
        return $query->row_array();
    }



    public function result_trx_produk($jumlah_pesanan, $id_produk)
    {
        $this->db->select('*');
        $this->db->from('trx_produk');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('sts_terjual', null);
        $this->db->limit($jumlah_pesanan);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_ke_produk_user($data)
    {
        $this->db->insert('tbl_zahir_produk_transaksi', $data);
        return $this->db->affected_rows();
    }

    public function update_ke_trx_produk($jumlah_pesanan, $id_produk, $data)
    {
        $this->db->where('id_produk', $id_produk);
        $this->db->where('sts_terjual', null);
        $this->db->limit($jumlah_pesanan);
        $this->db->update('trx_produk', $data);
    }

    public function result_produk_user($id_produk, $id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->where('sts_terjual', null);
        $this->db->where('id_user', $id_user);
        $this->db->where('id_produk', $id_produk);
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_produk_user_terjual($id_produk, $id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->where('sts_terjual', 1);
        $this->db->where('id_user', $id_user);
        $this->db->where('id_produk', $id_produk);
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_lokasi()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_lokasi');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function result_paket_pilihan_bulanan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_paket_bulanan_pilihan');
        $query = $this->db->get();
        return $query->result_array();
    }



    public function total_produk_user_keseluruhan($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->where('sts_terjual', null);
        $this->db->where('id_user', $id_user);
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->num_rows();
    }



    public function row_produk_userbyid($id_detail_produk_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->where('id_detail_produk_user', $id_detail_produk_user);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_data_produk_user($data, $where)
    {
        $this->db->update('tbl_zahir_produk_transaksi', $data, $where);
    }
    public function result_my_produk($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->where('tbl_zahir_produk_transaksi.id_user', $id_user);
        $this->db->where('tbl_zahir_produk_transaksi.sts_pencairan', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function count_my_produk($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_produk', 'tbl_zahir_produk_transaksi.id_produk = tbl_zahir_produk.id_produk', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.id_user', $id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function result_produk_filter($nama_produk = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk.id_user = tbl_zahir_user.id_user', 'left');
        if (isset($nama_produk)) {
            $this->db->like('nama_produk', $nama_produk);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    // INI UNTUK USER PEGAWAI

    public function result_riwayat_taggihan($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_riwayat_taggihan_prosess($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', 2);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_riwayat_taggihan_selesai($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', 1);
        $query = $this->db->get();
        return $query->result_array();
    }





    public function result_riwayat_taggihan_detail($id_riwayat_pemabayaran)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_riwayat_pemabayaran', $id_riwayat_pemabayaran);
        $query = $this->db->get();
        return $query->row_array();
    }


    private function _get_data_query_user_riwayat_pembayaran_bulanan($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
    }

    public function get_table_user_riwayat_pembayaran_bulanan($id_user)
    {
        $this->_get_data_query_user_riwayat_pembayaran_bulanan($id_user);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered_data_user_riwayat_pembayaran_bulanan($id_user)
    {
        $this->_get_data_query_user_riwayat_pembayaran_bulanan($id_user);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_data_user_riwayat_pembayaran_bulanan($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
        return $this->db->count_all_results();
    }

    public function cek_pembayaran_registrasi($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.jenis_taggihan', 'Pembayaran Registrasi');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cek_pembayaran_bulanan($id_user)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_user', $id_user);
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.jenis_taggihan', 'Pembayaran Bulanan');
        $this->db->where('MONTH(tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar)', date("m"));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_generate_taggihan_bulanan($data)
    {
        $this->db->insert('tbl_zahir_riwayat_pembayaran_bulanan', $data);
        return $this->db->affected_rows();
    }

    public function by_id_riwayat_pemabayaran($id_riwayat_pemabayaran)
    {
        $this->db->select('tbl_zahir_riwayat_pembayaran_bulanan.total_pembayaran,tbl_zahir_riwayat_pembayaran_bulanan.id_riwayat_pemabayaran,tbl_zahir_riwayat_pembayaran_bulanan.file,tbl_zahir_riwayat_pembayaran_bulanan.id_user,tbl_zahir_user.token_notif,tbl_zahir_user.nama_user,tbl_zahir_riwayat_pembayaran_bulanan.ket_pembayaran');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_riwayat_pembayaran_bulanan.id_user = tbl_zahir_user.id_user', 'right');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.id_riwayat_pemabayaran', $id_riwayat_pemabayaran);
        $query = $this->db->get();
        return $query->row_array();
    }

    function update_tbl_zahir_riwayat_pembayaran_bulanan($data, $where)
    {
        $this->db->update('tbl_zahir_riwayat_pembayaran_bulanan', $data, $where);
    }


    public function result_paket_langganan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_paket_bulanan_pilihan');
        $this->db->order_by('id_paket_bulanan_pilihan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function row_paket_langganan($id_paket_bulanan_pilihan)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_paket_bulanan_pilihan');
        $this->db->where('id_paket_bulanan_pilihan', $id_paket_bulanan_pilihan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function row_riwayat_taggihan($id_riwayat_pemabayaran)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_paket_bulanan_pilihan');
        $this->db->where('id_riwayat_pemabayaran', $id_riwayat_pemabayaran);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_bukti_bayar($data, $where)
    {
        $this->db->update('tbl_zahir_riwayat_pembayaran_bulanan', $data, $where);
    }


    public function count_riwayat_pembayaran_sudah_bayar()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_riwayat_pembayaran_bulanan.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', 1);
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 3) {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
            } else {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_riwayat_pembayaran_belum_bayar()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_riwayat_pembayaran_bulanan.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 3) {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
            } else {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function result_pembayaran_laporan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_riwayat_pembayaran_bulanan.id_user = tbl_zahir_user.id_user', 'left');
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 3) {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
            } else {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_pembayaran_sudah_laporan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_riwayat_pembayaran_bulanan.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', 1);
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 3) {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
            } else {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_pembayaran_belum_laporan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_riwayat_pembayaran_bulanan');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_riwayat_pembayaran_bulanan.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 3) {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', NULL);
            } else {
                $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.status_bayar', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_riwayat_pembayaran_bulanan.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    // INI UNTUK LANGGANAN produk
    public function count_riwayat_pembayaran_sudah_bayar_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'PAID');
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 'EXPIRED') {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
            } else {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_riwayat_pembayaran_belum_bayar_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 'EXPIRED') {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
            } else {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function result_pembayaran_laporan_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 'EXPIRED') {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
            } else {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_pembayaran_sudah_laporan_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'PAID');
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 'EXPIRED') {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
            } else {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_pembayaran_belum_laporan_pelanggan()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
        if (isset($_POST['status_bayar']) && $_POST['status_bayar'] != '') {
            if ($_POST['status_bayar'] == 'EXPIRED') {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', 'EXPIRED');
            } else {
                $this->db->where('tbl_zahir_produk_transaksi.sts_pembayaran', $_POST['status_bayar']);
            }
        }
        if (isset($_POST['tanggal_bayar_awal'], $_POST['tanggal_bayar_akhir']) && $_POST['tanggal_bayar_awal'] != '' && $_POST['tanggal_bayar_akhir'] != '') {
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar >=', $_POST['tanggal_bayar_awal']);
            $this->db->where('tbl_zahir_produk_transaksi.tanggal_bayar <=', $_POST['tanggal_bayar_akhir']);
        } else {
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    //get  jumlah data pelanggan bulanan aktif

    public function get_pelanggan_aktif()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->where('status', '1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    //get  jumlah data pelanggan bulanan non aktif

    public function get_pelanggan_non()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->where('status', '2');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }

    //get  jumlah data semua pelanggan bulanan

    public function get_pelanggan_semua()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_user');
        $this->db->where('id_role', '4');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return 0;
        }
    }



    public function result_pembayaran()
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function row_pembayaran($id_transaksi)
    {
        $this->db->select('*');
        $this->db->from('tbl_zahir_produk_transaksi');
        $this->db->join('tbl_zahir_user', 'tbl_zahir_produk_transaksi.id_user = tbl_zahir_user.id_user', 'left');
        $this->db->where('id_transaksi', $id_transaksi);
        $query = $this->db->get();
        return $query->row_array();
    }
}
