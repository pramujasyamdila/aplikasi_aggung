<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pegawai_angkringan_model extends CI_Model
{

    public function create_pegawai($data)
    {
        $this->db->insert('tbl_pegawai_angkringan', $data);
        return $this->db->affected_rows();
    }
    public function result_unit_kerja()
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function login_pegawai_angkringan($username)
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $this->db->where('username', $username);
        return $this->db->get()->row();
    }

    // ININ PRODUK
    public function create_produk($data)
    {
        $this->db->insert('angkringan_produk', $data);
        return $this->db->affected_rows();
    }



    public function delete_produk($id_produk)
    {
        $this->db->delete('angkringan_produk', ['id_produk' => $id_produk]);
        return $this->db->affected_rows();
    }
    public function tambah_ke_detail_rating_dan_komentar($data)
    {
        $this->db->insert('angkringan_detail_rating', $data);
        return $this->db->affected_rows();
    }

    public function result_produk()
    {
        $this->db->select('*');
        $this->db->from('angkringan_produk');
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_produk_filter($nama_produk = null)
    {
        $this->db->select('*');
        $this->db->from('angkringan_produk');
        if (isset($nama_produk)) {
            $this->db->like('nama_produk', $nama_produk);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_produk_food()
    {
        $this->db->select('*');
        $this->db->from('angkringan_produk');
        $this->db->where('id_kategori', 1);
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_produk_drink()
    {
        $this->db->select('*');
        $this->db->from('angkringan_produk');
        $this->db->where('id_kategori', 2);
        $this->db->order_by('id_produk', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function result_pegawai()
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $this->db->where('id_role', 1);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function delete_pegawai($id_pegawai)
    {
        $this->db->delete('tbl_pegawai_angkringan', ['id_pegawai' => $id_pegawai]);
        return $this->db->affected_rows();
    }

    public function row_produk($id_produk)
    {
        $this->db->select('*');
        $this->db->from('angkringan_produk');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get();
        return $query->row_array();
    }



    // keranjang
    public function add_to_cart($data)
    {
        $this->db->insert('angkringan_keranjang', $data);
        return $this->db->affected_rows();
    }
    public function cek_keranjnag($id_produk, $id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('angkringan_keranjang');
        $this->db->where('id_produk', $id_produk);
        $this->db->where('id_pegawai', $id_pegawai);;
        $query = $this->db->get();
        return $query->row_array();
    }
    public function cek_keranjnag_saya($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('angkringan_keranjang');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_keranjang.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->join('angkringan_produk', 'angkringan_keranjang.id_produk = angkringan_produk.id_produk', 'left');
        $this->db->where('angkringan_keranjang.id_pegawai', $id_pegawai);;
        $query = $this->db->get();
        return $query->result_array();
    }
    public function cek_keranjnagbyid($id_cart)
    {
        $this->db->select('*');
        $this->db->from('angkringan_keranjang');
        $this->db->where('id_cart', $id_cart);
        $query = $this->db->get();
        return $query->row_array();
    }


    public function update_to_cart($where, $data)
    {
        $this->db->update('angkringan_keranjang', $data, $where);
        return $this->db->affected_rows();
    }
    public function update_ke_produk($where, $data)
    {
        $this->db->update('angkringan_produk', $data, $where);
        return $this->db->affected_rows();
    }

    public function update_ke_pegawai($where, $data)
    {
        $this->db->update('tbl_pegawai_angkringan', $data, $where);
        return $this->db->affected_rows();
    }


    public function delete_to_cart($id_cart)
    {
        $this->db->delete('angkringan_keranjang', ['id_cart' => $id_cart]);
        return $this->db->affected_rows();
    }



    public function tambah_ke_angkringan_transaksi($data)
    {
        $this->db->insert('angkringan_transaksi', $data);
        return $this->db->affected_rows();
    }

    public function tambah_ke_angkringan_detail_transaksi($data)
    {
        $this->db->insert('angkringan_detail_transaksi', $data);
        return $this->db->affected_rows();
    }

    public function get_kode_po($text = null, $table = null, $field = null)
    {
        $this->db->select_max('no_order');
        $this->db->like($field, $text, 'after');
        $this->db->order_by($field, 'desc');
        $this->db->limit(1);
        return $this->db->get($table)->row_array()[$field];
    }
    public function result_orderan()
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.status_pesanan', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_detail_transaksi($no_order)
    {
        $this->db->select('*');
        $this->db->from('angkringan_detail_transaksi');
        $this->db->join('angkringan_produk', 'angkringan_detail_transaksi.id_produk = angkringan_produk.id_produk', 'left');
        $this->db->where('angkringan_detail_transaksi.no_order', $no_order);;
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_row_transaksi($no_order)
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('no_order', $no_order);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_to_order($where, $data)
    {
        $this->db->update('angkringan_transaksi', $data, $where);
        return $this->db->affected_rows();
    }

    public function result_orderan_prosess()
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.status_pesanan', 2);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_orderan_selesai()
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.status_pesanan', 4);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function result_orderan_pembayarn()
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.status_pesanan', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    // INI UNTUK PEMEBELI
    public function result_orderan_pemebeli($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.id_pegawai', $id_pegawai);
        $this->db->where('angkringan_transaksi.status_pesanan', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_orderan_prosess_pembeli($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.id_pegawai', $id_pegawai);
        $this->db->where('angkringan_transaksi.status_pesanan', 2);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function result_orderan_selesai_pembeli($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.id_pegawai', $id_pegawai);
        $this->db->where('angkringan_transaksi.status_pesanan', 4);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function result_orderan_pembayarn_pembeli($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('angkringan_transaksi');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_transaksi.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_transaksi.id_pegawai', $id_pegawai);
        $this->db->where('angkringan_transaksi.status_pesanan', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_detail_transaksi2($no_order)
    {
        $this->db->select('*');
        $this->db->from('angkringan_detail_transaksi');
        $this->db->where('angkringan_detail_transaksi.no_order', $no_order);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_rating($id_produk)
    {
        $this->db->select_avg('nilai_rating');
        $this->db->from('angkringan_detail_rating');
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_komentar($id_produk)
    {
        $this->db->select('*');
        $this->db->from('angkringan_detail_rating');
        $this->db->join('tbl_pegawai_angkringan', 'angkringan_detail_rating.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('angkringan_detail_rating.id_produk', $id_produk);
        $this->db->order_by('id_detail_rating_komentar');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_row_pegawai($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $this->db->where('id_pegawai', $id_pegawai);
        $query = $this->db->get();
        return $query->row_array();
    }

    // APLIKASI BANG SAM NASDEM
    public function create_warga($data)
    {
        $this->db->insert('nasdem_warga', $data);
        return $this->db->affected_rows();
    }
    public function result_warga()
    {
        $this->db->select('*');
        $this->db->from('nasdem_warga');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_ke_warga($where, $data)
    {
        $this->db->update('nasdem_warga', $data, $where);
        return $this->db->affected_rows();
    }


    public function delete_warga($id_warga)
    {
        $this->db->delete('nasdem_warga', ['id_warga' => $id_warga]);
        return $this->db->affected_rows();
    }



    public function count_warga()
    {
        $this->db->select('*');
        $this->db->from('nasdem_warga');
        $query = $this->db->get();
        return $query->num_rows();
    }
    
     public function get_role3()
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $this->db->where('id_role', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_timses_pegawai()
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $this->db->where('id_role', 3);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_warga_pegawai($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('nasdem_warga');
        $this->db->where('id_pegawai', $id_pegawai);
        $query = $this->db->get();
        return $query->result_array();
    }
    
      public function get_pegawai($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('tbl_pegawai_angkringan');
        $this->db->where('id_pegawai', $id_pegawai);
        $query = $this->db->get();
        return $query->row_array();
    }

// View Antareja
        public function result_activity_detail2()
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity_detail');
        $query = $this->db->get();
        return $query->result_array();
    }

      public function result_activity2_detail2()
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity2_detail');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    // ini untuk antareza
        public function create_activity($data)
    {
        $this->db->insert('tbl_antareza_activity_detail', $data);
        return $this->db->affected_rows();
    }

        public function result_activity($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity_detail');
          $this->db->join('tbl_pegawai_angkringan', 'tbl_antareza_activity_detail.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('tbl_antareza_activity_detail.id_pegawai',$id_pegawai);
        $this->db->group_by('tbl_antareza_activity_detail.waktu');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_activity_detail($id_pegawai,$waktu)
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity_detail');
        $this->db->join('tbl_pegawai_angkringan', 'tbl_antareza_activity_detail.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('tbl_antareza_activity_detail.id_pegawai',$id_pegawai);
         $this->db->where('tbl_antareza_activity_detail.waktu',$waktu);
        $query = $this->db->get();
        return $query->result_array();
    }
    


        public function count_activity($id_pegawai,$waktu)
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity_detail');
        $this->db->join('tbl_pegawai_angkringan', 'tbl_antareza_activity_detail.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('tbl_antareza_activity_detail.id_pegawai',$id_pegawai);
        $this->db->where('tbl_antareza_activity_detail.waktu',$waktu);
        $query = $this->db->get();
        return $query->num_rows();
    }

        
    public function delete_activity($id_activity_detail)
    {
        $this->db->delete('tbl_antareza_activity_detail', ['id_activity_detail' => $id_activity_detail]);
        return $this->db->affected_rows();
    }

    
    public function update_ke_activity($where, $data)
    {
        $this->db->update('tbl_antareza_activity_detail', $data, $where);
        return $this->db->affected_rows();
    }


    
    // ini untuk antareza
        public function create_activity2($data)
    {
        $this->db->insert('tbl_antareza_activity2_detail', $data);
        return $this->db->affected_rows();
    }

        public function result_activity2($id_pegawai)
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity2_detail');
          $this->db->join('tbl_pegawai_angkringan', 'tbl_antareza_activity2_detail.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('tbl_antareza_activity2_detail.id_pegawai',$id_pegawai);
        $this->db->group_by('tbl_antareza_activity2_detail.waktu');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function result_activity2_detail($id_pegawai,$waktu)
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity2_detail');
        $this->db->join('tbl_pegawai_angkringan', 'tbl_antareza_activity2_detail.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('tbl_antareza_activity2_detail.id_pegawai',$id_pegawai);
         $this->db->where('tbl_antareza_activity2_detail.waktu',$waktu);
        $query = $this->db->get();
        return $query->result_array();
    }
    


        public function count_activity2($id_pegawai,$waktu)
    {
        $this->db->select('*');
        $this->db->from('tbl_antareza_activity2_detail');
        $this->db->join('tbl_pegawai_angkringan', 'tbl_antareza_activity2_detail.id_pegawai = tbl_pegawai_angkringan.id_pegawai', 'left');
        $this->db->where('tbl_antareza_activity2_detail.id_pegawai',$id_pegawai);
        $this->db->where('tbl_antareza_activity2_detail.waktu',$waktu);
        $query = $this->db->get();
        return $query->num_rows();
    }

        
    public function delete_activity2($id_activity2_detail)
    {
        $this->db->delete('tbl_antareza_activity2_detail', ['id_activity_detail' => $id_activity2_detail]);
        return $this->db->affected_rows();
    }

    
    public function update_ke_activity2($where, $data)
    {
        $this->db->update('tbl_antareza_activity2_detail', $data, $where);
        return $this->db->affected_rows();
    }
}
